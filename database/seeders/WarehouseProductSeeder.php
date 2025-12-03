<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class WarehouseProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = json_decode(Storage::disk('public')->get('univexnav_iteminventory.json'), true);
        $items = collect($items[2]['data']);

        $results = collect();

        $warehouses = Warehouse::all()->keyBy('code');

        $items->chunk(10000)->each(function ($chunk, $key) use (&$results, $warehouses) {
            $productPrices = ProductPrice::query()
                ->whereIn('code', $chunk->pluck('IDPrice'))
                ->select(['id', 'code'])
                ->get()
                ->keyBy('code');

            $chunkResults = $chunk->map(function ($item) use ($productPrices, $warehouses) {

                if (!isset($productPrices[$item['IDPrice']]) ||
                    !isset($warehouses[$item['LocationCode']])) {
                    return null;
                }

                return [
                    'product_price_id'  => $productPrices[$item['IDPrice']]->id,
                    'warehouse_id'      => $warehouses[$item['LocationCode']]->id,
                    'quantity'          => (int)$item['Quantity'],
                ];
            });

            $results = $results->merge($chunkResults);
            echo $key . PHP_EOL;
            // Освобождаем память
            unset($products, $chunkResults);
        });

        DB::transaction(function () use ($results) {
            $results->chunk(10000)->each(function ($chunk, $key) {
                try {
                    $attemptedCount = $chunk->count();
                    $insertedCount = WarehouseProduct::query()->insertOrIgnore($chunk->toArray());

                    echo 'Вставка: ' . $key . PHP_EOL;

                } catch (\Throwable $throwable) {
                    return;
                }
            });
        });
    }
}
