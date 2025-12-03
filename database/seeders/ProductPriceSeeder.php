<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductPriceSeeder extends Seeder
{
    public Carbon $now;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prices = json_decode(Storage::disk('public')->get('univexnav_pricelist.json'), true);
        $this->now = now();
        $results = collect();

// Обрабатываем чанками исходные данные
        collect($prices[2]['data'])->chunk(5000)->each(function ($chunk, $key) use (&$results) {
            // Получаем уникальные IDPrice из текущего чанка
            $priceCodes = $chunk->pluck('IDPrice');

            // Загружаем только продукты для текущего чанка
            $products = Product::query()
                ->whereIn('price_code', $priceCodes)
                ->select(['id', 'price_code'])
                ->get()
                ->keyBy('price_code');

            $chunkResults = $chunk->map(function ($item) use ($products) {
                if (!isset($products[$item['IDPrice']])) {
                    return null;
                }

                return [
                    'product_id' => $products[$item['IDPrice']]->id,
                    'discount_type_id' => $item['SalesType'] + 1,
                    'price' => (int) str_replace([',', ' '], '', $item['Price']),
                    'discount' => (int) str_replace([',', ' '], '', $item['Discount']),
                    'code' => $item['IDPrice'],
                    'created_at' => $this->now,
                    'updated_at' => $this->now,
                ];
            });

            $results = $results->merge($chunkResults);

            // Освобождаем память
            unset($products, $chunkResults);
        });

        DB::transaction(function () use ($results) {
            $results->chunk(5000)->each(function ($chunk) {
                try {
                    $attemptedCount = $chunk->count();
                    $insertedCount = ProductPrice::query()->insertOrIgnore($chunk->toArray());

                } catch (\Throwable $throwable) {
                    return;
                }
            });
        });
    }
}
