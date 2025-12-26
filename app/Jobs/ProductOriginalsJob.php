<?php

namespace App\Jobs;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductOriginal;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class ProductOriginalsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->syncInternalProductOriginal();
    }

    private function syncInternalProductOriginal()
    {
        $products = Product::query()
            ->whereNotNull('code')
            ->pluck('id', 'code')
            ->toArray();

        $manufacturers = Manufacturer::query()
            ->whereNotNull('code')
            ->pluck('id', 'name')
            ->toArray();

        $now = now();

        DB::connection('external')
            ->table('univexnav_originals')
            ->whereNotNull('idSite')
            ->whereNotNull('Mark')
            ->whereNotNull('origNo')
            ->orderBy('idSite')
            ->chunk(5000, function ($batch) use ($products, $now, $manufacturers) {
                $data = [];

                foreach ($batch as $row) {
                    $productKey = $row->idSite;
                    if (empty($productKey) || !isset($products[$productKey])) continue;

                    $manufacturerId = $manufacturers[$row->mark] ?? null;
                    if (!$manufacturerId) continue;

                    $data[] = [
                        'product_id'        => $products[$productKey],
                        'manufacturer_id'   => $manufacturerId,
                        'oem'               => $row->origNo,
                        'created_at'        => $now,
                        'updated_at'        => $now,
                    ];

                    if (count($data) >= 1000) {
                        ProductOriginal::query()->upsert($data, ['product_id', 'manufacturer_id', 'oem'], [
                            'oem', 'updated_at'
                        ]);
                        $data = [];
                    }
                }

                if (!empty($data)) {
                    ProductOriginal::query()->upsert($data, ['product_id', 'manufacturer_id', 'oem'], [
                        'oem', 'updated_at'
                    ]);
                }
            });
    }
}
