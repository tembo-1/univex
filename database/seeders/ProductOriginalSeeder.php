<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductOriginal;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductOriginalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductOriginal::query()->truncate();

        $json = Storage::disk('public')->get('univexnav_originals.json');
        $originals = json_decode($json, true);

        // Обрабатываем данные пачками
        collect($originals[2]['data'])->chunk(1000)->each(function ($chunk) {

            // Предварительная загрузка для текущей пачки
            $manufactureNames = $chunk->pluck('Mark')->unique()->filter();
            $productCodes = $chunk->pluck('IDSIte')->unique()->filter();

            $existingManufactures = Manufacturer::whereIn('name', $manufactureNames)
                ->get()
                ->keyBy('name');

            $existingProducts = Product::whereIn('code', $productCodes)
                ->get()
                ->keyBy('code');

            $productOriginalsToCreate = [];

            foreach ($chunk as $original) {
                if (empty($original['IDSIte']) || empty($original['Mark'])) {
                    continue;
                }

                $product = $existingProducts->get($original['IDSIte']);
                if (!$product) {
                    continue;
                }

                $manufactureName = $original['Mark'];
                $manufacture = $existingManufactures->get($manufactureName);

                if (!$manufacture) {
                    $slug = Str::slug($manufactureName);
                    $manufacture = Manufacturer::create([
                        'name' => $manufactureName,
                        'slug' => $slug,
                        'is_visible' => 0,
                    ]);
                    $existingManufactures->put($manufactureName, $manufacture);
                }

                $productOriginalsToCreate[] = [
                    'oem' => $original['OriginalManufacturerNo'] ?? null,
                    'product_id' => $product->id,
                    'manufacturer_id' => $manufacture->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Массовая вставка для текущей пачки
            if (!empty($productOriginalsToCreate)) {
                ProductOriginal::insert($productOriginalsToCreate);
            }

            // Очищаем память после обработки пачки
            unset($manufactureNames, $productCodes, $existingManufactures, $existingProducts, $productOriginalsToCreate);
            gc_collect_cycles();
        });
    }
}
