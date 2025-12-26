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
        $this->syncAllManufacturers();
        $this->syncAllWarehouses();
        $this->syncExternalProducts();
        $this->syncInternalProducts();
    }

    private function syncInternalProducts()
    {
        $manufacturers = Manufacturer::query()->pluck('id', 'code')->toArray();
        $now = now();

        DB::connection('external')
            ->table('univexnav_item')
            ->whereNotNull('IDSite')
            ->whereNotNull('No')
            ->whereNotNull('Description')
            ->select(['IDSite', 'no', 'OrigNo', 'description', 'minQty', 'manID', 'matchCode', 'sale', 'discount', 'order'])
            ->orderBy('IDSite')
            ->chunk(5000, function ($batch) use ($manufacturers, $now) {
                $data = [];

                foreach ($batch as $row) {
                    $manKey = $row->manID;
                    if (empty($manKey) || !isset($manufacturers[$manKey])) continue;

                    $data[] = [
                        'name' => $row->description,
                        'sku' => $row->no,
                        'oem' => $row->OrigNo,
                        'code' => $row->IDSite,
                        'on_sale' => (bool)$row->sale,
                        'sale_discount' => (float)$row->discount,
                        'min_order_quantity' => (int)$row->minQty,
                        'manufacturer_id' => $manufacturers[$manKey],
                        'product_warehouse_status_id' => (int)$row->order + 1,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    if (count($data) >= 1000) {
                        Product::query()->upsert($data, ['code'], [
                            'name', 'sku', 'oem', 'on_sale', 'sale_discount',
                            'min_order_quantity', 'manufacturer_id', 'product_warehouse_status_id', 'updated_at'
                        ]);
                        $data = [];
                    }
                }

                if (!empty($data)) {
                    Product::query()->upsert($data, ['code'], [
                        'name', 'sku', 'oem', 'on_sale', 'sale_discount',
                        'min_order_quantity', 'manufacturer_id', 'product_warehouse_status_id', 'updated_at'
                    ]);
                }
            });
    }

    private function syncExternalProducts(): void
    {
        $manufacturers = Manufacturer::pluck('id', 'code')->toArray();
        $now = now();

        DB::connection('external')
            ->table('pricedata_itemidcorrespondence')
            ->where('site', '!=', 0)
            ->whereNotNull('IDSite')
            ->whereNotNull('No')
            ->whereNotNull('Description')
            ->select(['IDSite', 'No', 'OrigNo', 'Description', 'MinQty', 'ManIDForeign'])
            ->orderBy('IDSite')
            ->chunk(5000, function ($batch) use ($manufacturers, $now) { // chunk ↓
                $data = [];

                foreach ($batch as $row) {
                    $manKey = $row->ManIDForeign;
                    if (empty($manKey) || !isset($manufacturers[$manKey])) continue;

                    $data[] = [
                        'name' => $row->Description,
                        'sku' => $row->No,
                        'oem' => $row->OrigNo,
                        'code' => $row->IDSite,
                        'on_sale' => 0,
                        'sale_discount' => 0.00,
                        'min_order_quantity' => (int)$row->MinQty,
                        'manufacturer_id' => $manufacturers[$manKey],
                        'product_warehouse_status_id' => 2,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    if (count($data) >= 1000) {
                        Product::upsert($data, ['code'], [
                            'name', 'sku', 'oem', 'on_sale', 'sale_discount',
                            'min_order_quantity', 'manufacturer_id', 'product_warehouse_status_id', 'updated_at'
                        ]);
                        $data = [];
                    }
                }

                // Финальный upsert
                if (!empty($data)) {
                    Product::upsert($data, ['code'], [
                        'name', 'sku', 'oem', 'on_sale', 'sale_discount',
                        'min_order_quantity', 'manufacturer_id', 'product_warehouse_status_id', 'updated_at'
                    ]);
                }
            });
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
            $name = $ext->manName;

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
            $manufacturerCode = $ext->ManIDForeign;
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
            foreach (array_chunk($data, 1000) as $chunk) {
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
