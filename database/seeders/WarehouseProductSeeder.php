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

        // Получаем уникальные коды через коллекции
        $allItems = collect($items[2]['data']);

        $warehouseCodes = $allItems->pluck('LocationCode')->unique()->values();
        $productCodes = $allItems->pluck('IDSite')->unique()->values();

        // Пакетная загрузка продуктов
        $products = collect();
        $productCodes->chunk(20000)->each(function ($chunk) use (&$products) {
            Product::query()
                ->whereIn('code', $chunk)
                ->select('id', 'code')
                ->cursor()
                ->each(function ($product) use (&$products) {
                    $products[$product->code] = $product->id;
                });
        });

        // Пакетная загрузка складов
        $warehouses = collect();
        $warehouseCodes->chunk(20000)->each(function ($chunk) use (&$warehouses) {
            Warehouse::query()
                ->whereIn('code', $chunk)
                ->select('id', 'code')
                ->cursor()
                ->each(function ($warehouse) use (&$warehouses) {
                    $warehouses[$warehouse->code] = $warehouse->id;
                });
        });

        // Обрабатываем пакетами
        $allItems->chunk(5000)->each(function ($chunk) use ($products, $warehouses) {
            $warehouseProducts = $chunk->map(function ($item) use ($products, $warehouses) {
                $productId = $products[$item['IDSite']] ?? null;
                $warehouseId = $warehouses[$item['LocationCode']] ?? null;

                return $productId && $warehouseId ? [
                    'product_id' => $productId,
                    'warehouse_id' => $warehouseId,
                    'quantity' => $item['Quantity'],
                ] : null;
            })->filter()->values()->toArray();

            if (!empty($warehouseProducts)) {
                WarehouseProduct::query()->insertOrIgnore($warehouseProducts);
            }
        });
    }
}
