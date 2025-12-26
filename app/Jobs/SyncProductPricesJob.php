<?php

namespace App\Jobs;

use App\Models\DiscountType;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class SyncProductPricesJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->syncInternalProductPrices();
        $this->syncExternalProductPrices();
    }

    private function syncExternalProductPrices()
    {
        $products = Product::query()
            ->whereNotNull('code')
            ->pluck('id', 'code')
            ->toArray();

        $now = now();

        DB::connection('external')
            ->table('pricedata_itemidcorrespondence')
            ->whereNotNull('IDSite')
            ->orderBy('IDSite')
            ->chunk(5000, function ($batch) use ($products, $now) {
                $data = [];

                foreach ($batch as $row) {
                    $productKey = $row->IDSite;
                    if (empty($productKey) || !isset($products[$productKey])) continue;

                    $data[] = [
                        'product_id' => $products[$productKey],
                        'discount_type_id' => 2,
                        'price' => $this->priceToKopecks($row->Price),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    if (count($data) >= 1000) {
                        ProductPrice::query()->upsert($data, ['product_id', 'discount_type_id'], [
                            'price', 'updated_at'
                        ]);
                        $data = [];
                    }
                }

                if (!empty($data)) {
                    ProductPrice::query()->upsert($data, ['product_id', 'discount_type_id'], [
                        'price', 'updated_at'
                    ]);
                }
            });
    }

    private function syncInternalProductPrices()
    {
        $products = Product::query()
            ->whereNotNull('code')
            ->pluck('id', 'code')
            ->toArray();

        $discountTypes = DiscountType::query()
            ->pluck('id', 'code')
            ->toArray();

        $now = now();

        DB::connection('external')
            ->table('univexnav_pricelist')
            ->whereNotNull('idSite')
            ->where('salesType', '!=', 0)
            ->whereNull('salesCode')
            ->orderBy('idSite')
            ->chunk(5000, function ($batch) use ($products, $now, $discountTypes) {
                $data = [];

                foreach ($batch as $row) {
                    $productKey = $row->idSite;
                    if (empty($productKey) || !isset($products[$productKey])) continue;

                    $discountTypeId = $discountTypes[(int)$row->salesType] ?? null;
                    if (!$discountTypeId) continue;

                    $data[] = [
                        'product_id' => $products[$productKey],
                        'discount_type_id' => $discountTypeId,
                        'price' => $this->priceToKopecks($row->price),
                        'valid_from' => $row->startDate,
                        'valid_until' => $row->endDate,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    if (count($data) >= 1000) {
                        ProductPrice::query()->upsert($data, ['product_id', 'discount_type_id'], [
                            'price', 'valid_from', 'valid_until', 'updated_at'
                        ]);
                        $data = [];
                    }
                }

                if (!empty($data)) {
                    ProductPrice::query()->upsert($data, ['product_id', 'discount_type_id'], [
                        'price', 'valid_from', 'valid_until', 'updated_at'
                    ]);
                }
            });
    }

    private function priceToKopecks(string $price): int
    {
        // Убираем пробелы и заменяем запятые на точки
        $price = str_replace([' ', ','], ['', '.'], $price);

        // Разделяем на рубли и копейки
        $parts = explode('.', $price);

        $rubles = $parts[0];
        $kopecks = $parts[1] ?? '00';

        // Дополняем копейки до 2 знаков
        $kopecks = str_pad($kopecks, 2, '0', STR_PAD_RIGHT);

        // Берем только 2 знака после запятой
        $kopecks = substr($kopecks, 0, 2);

        return (int)($rubles . $kopecks);
    }
}
