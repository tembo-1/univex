<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductWarehouseStatus;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('public')->get('univexnav_item.json');
        $products = json_decode($json, true);

        $productsData = [];

        foreach ($products[2]['data'] as $item) {
            $key = $item['IDSite'];
            if (!isset($productsData[$key])) {
                $productsData[$key] = $item;
            }
        }

        $productsData = collect(array_values($productsData));


        $manufactureCodes = $productsData->pluck('ManID')->unique()->filter();
        $manufactures = Manufacturer::query()->whereIn('code', $manufactureCodes)
            ->get()
            ->keyBy('code');

// Предзагружаем статусы за один запрос
        $warehouseStatuses = ProductWarehouseStatus::whereIn('name', [
            'Складской', 'Заказной', 'Не используемый'
        ])->get()->keyBy('name');

// Маппинг Order → имя статуса
        $orderStatusMap = [
            0 => 'Складской',
            1 => 'Заказной',
            2 => 'Не используемый'
        ];

        $formatDecimal = function ($value) {
            if (empty($value)) return 0;

            // Если значение уже число - возвращаем как есть
            if (is_numeric($value)) return $value;

            // Заменяем запятую на точку и преобразуем к float
            $cleaned = str_replace(',', '.', $value);

            // Удаляем все пробелы (на случай тысяч)
            $cleaned = str_replace(' ', '', $cleaned);

            return (float) $cleaned;
        };

// Подготавливаем данные для массовой вставки
        $productsToInsert = $productsData->map(function ($product) use ($manufactures, $warehouseStatuses, $orderStatusMap, $formatDecimal) {
            $manufacture = $manufactures->get($product['ManID']);
            $statusName = $orderStatusMap[$product['order']] ?? null;
            $status = $statusName ? $warehouseStatuses->get($statusName) : null;

            return [
                'name' => $product['Description'],
                'sku' => $product['No'],
                'oem' => $product['OrigNo'],
                'search_text' => $product['MatchCode'],
                'on_sale' => $product['Sale'],
                'sale_discount' => $formatDecimal($product['sDiscount'] ?? 0),
                'min_order_quantity' => (int)$product['minQty'],
                'product_warehouse_status_id' => $status->id ?? null,
                'manufacturer_id' => $manufacture->id ?? null,
                'code' => $product['IDSite'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->filter(function ($product) {
            // Фильтруем записи где нет обязательных данных
            return !empty($product['sku']) && !empty($product['name']) && $product['product_warehouse_status_id'] != 3;
        })->chunk(5000); // Разбиваем на части для вставки

// Массовая вставка частями
        foreach ($productsToInsert as $chunk) {
            Product::query()->insert($chunk->toArray());
        }
    }
}
