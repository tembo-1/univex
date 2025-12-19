<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\User;
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

        // Шаг 1: Собираем все уникальные коды продуктов
        $allProductCodes = collect($prices[2]['data'])->pluck('IDSite')->values();

        // Шаг 2: Пакетная загрузка продуктов
        $products = collect();
        $allProductCodes->chunk(10000)->each(function ($codesChunk) use (&$products) {
            Product::query()
                ->whereIn('code', $codesChunk)
                ->select('id', 'code')
                ->chunkById(2000, function ($chunkedProducts) use (&$products) {
                    foreach ($chunkedProducts as $product) {
                        $products[$product->code] = $product->id;
                    }
                }, 'id');
        });

        // Шаг 3: Собираем все уникальные коды пользователей для предзагрузки
        $allUserCodes = collect($prices[2]['data'])
            ->where('SalesType', 0)
            ->pluck('SalesCode')
            ->filter()
            ->unique()
            ->values();

        // Шаг 4: Пакетная загрузка пользователей
        $users = collect();
        $allUserCodes->chunk(10000)->each(function ($codesChunk) use (&$users) {
            User::query()
                ->whereIn('code', $codesChunk)
                ->select('id', 'code')
                ->chunkById(2000, function ($chunkedUsers) use (&$users) {
                    foreach ($chunkedUsers as $user) {
                        $users[$user->code] = $user->id;
                    }
                }, 'id');
        });

        // Шаг 5: Подготовка данных для вставки
        $insertData = [];
        $batchSize = 5000;

        // Обрабатываем данные пакетами
        foreach (array_chunk($prices[2]['data'], $batchSize) as $chunkIndex => $dataChunk) {
            $chunkResults = [];

            foreach ($dataChunk as $item) {
                $productId = $products[$item['IDSite']] ?? null;

                if (!$productId) {
                    continue;
                }

                $userId = null;
                if ((int)$item['SalesType'] == 0 && !empty($item['SalesCode'])) {
                    $userId = $users[$item['SalesCode']] ?? null;
                }

                // Оптимизированное преобразование цены
                $price = (int)round(floatval(str_replace(',', '.', $item['Price'])) * 100);

                $chunkResults[] = [
                    'product_id' => $productId,
                    'discount_type_id' => (int)$item['SalesType'] + 1,
                    'price' => $price,
                    'user_id' => $userId,
                    'created_at' => $this->now,
                    'updated_at' => $this->now,
                ];
            }

            // Вставляем пакет в базу
            if (!empty($chunkResults)) {
                try {
                    ProductPrice::query()->insertOrIgnore($chunkResults);
                } catch (\Throwable $throwable) {

                }
            }

            // Очищаем память
            unset($chunkResults, $dataChunk);

            // Выводим прогресс
            echo "Processed batch: " . ($chunkIndex + 1) . "\n";
        }

        // Очищаем память от больших коллекций
        unset($products, $users, $allProductCodes, $allUserCodes, $prices);

        echo "Import completed successfully.\n";
    }
}
