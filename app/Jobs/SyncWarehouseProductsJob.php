<?php

namespace App\Jobs;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductOriginal;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class SyncWarehouseProductsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->syncInternal();
        $this->syncExternal();
    }

    private function syncExternal()
    {
        $products = Product::query()
            ->whereNotNull('code')
            ->pluck('id', 'code')
            ->toArray();

        $warehouses = Warehouse::query()
            ->whereNotNull('code')
            ->pluck('id', 'code')
            ->toArray();

        $now = now();

        DB::connection('external')
            ->table('pricedata_itemidcorrespondence')
            ->whereNotNull('IDSite')
            ->whereNotNull('VendorID')
            ->whereNotNull('Inventory')
            ->orderBy('IDSite')
            ->chunk(5000, function ($batch) use ($products, $now, $warehouses) {
                $data = [];

                foreach ($batch as $row) {
                    $productKey = $row->IDSite;
                    if (empty($productKey) || !isset($products[$productKey])) continue;

                    $warehouseId = $warehouses[$row->VendorID] ?? null;
                    if (!$warehouseId) continue;

                    $data[] = [
                        'product_id'        => $products[$productKey],
                        'warehouse_id'      => $warehouseId,
                        'quantity'          => $row->Inventory,
                        'created_at'        => $now,
                        'updated_at'        => $now,
                    ];

                    if (count($data) >= 1000) {
                        WarehouseProduct::query()->upsert($data, ['product_id', 'warehouse_id'], [
                            'quantity', 'date_shipment', 'updated_at'
                        ]);
                        $data = [];
                    }
                }

                if (!empty($data)) {
                    WarehouseProduct::query()->upsert($data, ['product_id', 'warehouse_id'], [
                        'quantity', 'date_shipment', 'updated_at'
                    ]);
                }
            });
    }

    private function syncInternal()
    {
        $products = Product::query()
            ->whereNotNull('code')
            ->pluck('id', 'code')
            ->toArray();

        $warehouses = Warehouse::query()
            ->whereNotNull('code')
            ->pluck('id', 'code')
            ->toArray();

        $now = now();

        DB::connection('external')
            ->table('univexnav_iteminventory')
            ->whereNotNull('idSite')
            ->whereNotNull('locationCode')
            ->whereNotNull('termin')
            ->orderBy('idSite')
            ->chunk(5000, function ($batch) use ($products, $now, $warehouses) {
                $data = [];

                foreach ($batch as $row) {
                    $productKey = $row->idSite;
                    if (empty($productKey) || !isset($products[$productKey])) continue;

                    $warehouseId = $warehouses[$row->locationCode] ?? null;
                    if (!$warehouseId) continue;

                    $data[] = [
                        'product_id'        => $products[$productKey],
                        'warehouse_id'      => $warehouseId,
                        'quantity'          => $row->inventory,
                        'date_shipment'     => $row->termin,
                        'created_at'        => $now,
                        'updated_at'        => $now,
                    ];

                    if (count($data) >= 1000) {
                        WarehouseProduct::query()->upsert($data, ['product_id', 'warehouse_id'], [
                            'quantity', 'date_shipment', 'updated_at'
                        ]);
                        $data = [];
                    }
                }

                if (!empty($data)) {
                    WarehouseProduct::query()->upsert($data, ['product_id', 'warehouse_id'], [
                        'quantity', 'date_shipment', 'updated_at'
                    ]);
                }
            });
    }
}
