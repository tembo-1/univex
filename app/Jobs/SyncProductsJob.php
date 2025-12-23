<?php

namespace App\Jobs;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class SyncProductsJob implements ShouldQueue
{
    use Queueable;

    protected $manufacturers;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
//        $this->syncAllManufacturers();
//        $this->syncAllWarehouses();
        $this->syncExternalProducts();
    }

    private function syncExternalProducts(): void
    {
        $startTime = microtime(true);
        $now = now();
        $manufacturers = Manufacturer::pluck('id', 'code')->toArray();

        // **chunk(25000) вместо cursor()** - быстрее чтение!
        DB::connection('external')
            ->table('pricedata_itemidcorrespondence')
            ->where('site', '!=', 0)
            ->whereNotNull('IDSite')
            ->whereNotNull('No')
            ->whereNotNull('Description')
            ->whereIn('ManIDForeign', array_keys($manufacturers))
            ->select(['IDSite', 'No', 'OrigNo', 'Description', 'MinQty', 'ManIDForeign'])
            ->orderBy('IDSite')
            ->chunk(25000, function ($batch) use ($manufacturers, $now) {
            $data = [];
            foreach ($batch as $row) { // обычный foreach!
                $manufacturerId = $manufacturers[(string)$row->ManIDForeign] ?? null;
                if (!$manufacturerId) continue;

                $data[] = [
                    'name' => $row->Description,
                    'sku' => $row->No,
                    'oem' => $row->OrigNo,
                    'code' => (string)$row->IDSite,
                    'on_sale' => 0,
                    'sale_discount' => 0,
                    'min_order_quantity' => (int)$row->MinQty,
                    'manufacturer_id' => $manufacturerId,
                    'product_warehouse_status_id' => 2,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            // **upsert(2500) вместо 5000** - меньше write-нагрузка
            if (!empty($data)) {
                foreach (array_chunk($data, 2500) as $chunk) {
                    Product::upsert($chunk, ['code'], [
                        'name', 'sku', 'oem', 'on_sale', 'sale_discount',
                        'min_order_quantity', 'manufacturer_id', 'product_warehouse_status_id', 'updated_at'
                    ]);
                }
            }
        });

        echo "✅ " . number_format(microtime(true) - $startTime, 2) . " сек\n";
    }


    private function syncAllWarehouses(): void
    {
        $internalWarehouses = DB::connection('external')
            ->table('univexnav_stock')
            ->where('Active', 1)
            ->whereNotNull('StockSiteName')
            ->select([
                'StockID',
                'StockSiteName',
                'Active'
            ])
            ->get();

        $data = [];
        $now = now();

        foreach ($internalWarehouses as $ext) {
            try {
                $code = (string)$ext->StockID;

                $name = $ext->StockSiteName;

                $data[] = [
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'code' => $code,
                    'is_active' => (bool)$ext->Active,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

            } catch (Throwable $e) {
                continue;
            }
        }

        if (!empty($data)) {
            Warehouse::query()
                ->upsert(
                    $data,
                    ['code'],
                    ['name', 'slug', 'is_active', 'updated_at']
                );
        }

    }

    private function syncAllManufacturers(): void
    {
        $now = now();
        $data = [];

        $internalManufacturers = DB::connection('external')
            ->table('univexnav_manufacturer')
            ->get();

        foreach ($internalManufacturers as $ext) {
            $code = (string)$ext->manID;
            $name = trim($ext->manName);

            if (empty($name)) continue;

            $data[] = [
                'name'          => $name,
                'slug'          => Str::slug($name),
                'code'          => $code,
                'is_active'     => true,
                'is_visible'    => false,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        $externalManufacturers = DB::connection('external')
            ->table('pricedata_manidcorrespondence')
            ->select('ManIDForeign', 'ManNameForeign')
            ->groupBy('ManIDForeign', 'ManNameForeign')
            ->get();

        foreach ($externalManufacturers as $ext) {
            $manufacturerCode = (string)$ext->ManIDForeign;
            $externalManufacturerName = trim($ext->ManNameForeign);

            if (empty($externalManufacturerName)) continue;

            $data[] = [
                'name'          => $externalManufacturerName,
                'slug'          => Str::slug($externalManufacturerName),
                'code'          => $manufacturerCode,
                'is_active'     => true,
                'is_visible'    => false,
                'created_at'    => $now,
                'updated_at'    => $now,
            ];
        }

        if (!empty($data)) {
            foreach (array_chunk($data, 5000) as $chunk) {
                Manufacturer::query()
                    ->upsert(
                        $chunk,
                        ['code'],
                        ['name', 'slug', 'is_active', 'is_visible', 'updated_at']
                    );
            }
        }
    }
}
