<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductSubstitution;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSubstitutionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductSubstitution::query()->truncate();

        $json = Storage::disk('public')->get('univexnav_itemsubstitution.json');
        $substitutions = json_decode($json, true);

        $substitutionData = collect($substitutions[2]['data']);

        // Обрабатываем данные небольшими пачками
        $substitutionData->chunk(5000)->each(function ($chunk) {

            // Собираем коды продуктов для текущей пачки
            $allCodes = $chunk->pluck('IDSite')
                ->merge($chunk->pluck('SubstID'))
                ->unique()
                ->filter()
                ->values();

            if ($allCodes->isEmpty()) {
                return;
            }

            // Предзагружаем продукты для текущей пачки
            $products = Product::whereIn('code', $allCodes)
                ->get()
                ->keyBy('code');

            $substitutionsToCreate = [];

            foreach ($chunk as $substitution) {
                $product = $products->get($substitution['IDSite'] ?? null);
                $substitute = $products->get($substitution['SubstID'] ?? null);

                if (!$product || !$substitute) {
                    continue;
                }

                $substitutionsToCreate[] = [
                    'product_id'    => $product->id,
                    'substitute_id' => $substitute->id,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ];
            }

            // Вставляем еще меньшими пачками
            if (!empty($substitutionsToCreate)) {
                collect($substitutionsToCreate)->chunk(5000)->each(function ($insertChunk) {
                    ProductSubstitution::insert($insertChunk->toArray());
                });
            }

            // Очищаем память
            unset($products, $substitutionsToCreate, $allCodes);
            gc_collect_cycles();
        });
    }
}
