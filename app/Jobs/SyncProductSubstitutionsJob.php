<?php

namespace App\Jobs;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductOriginal;
use App\Models\ProductSubstitution;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class SyncProductSubstitutionsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->syncSubstitutions();
    }

    public function syncSubstitutions()
    {
        $products = Product::query()
            ->whereNotNull('code')
            ->pluck('id', 'code')
            ->toArray();

        $now = now();

        DB::connection('external')
            ->table('univexnav_itemsubstitutions')
            ->whereNotNull('idSite')
            ->whereNotNull('idSubst')
            ->orderBy('idSite')
            ->chunk(5000, function ($batch) use ($products, $now) {
                $data = [];

                foreach ($batch as $row) {
                    $productKey = $row->idSite;
                    if (empty($productKey) || !isset($products[$productKey])) continue;

                    $substituteKey = $row->idSubst;
                    if (empty($substituteKey) || !isset($products[$substituteKey])) continue;

                    $data[] = [
                        'product_id'            => $products[$productKey],
                        'substitute_id'         => $products[$substituteKey],
                        'created_at'            => $now,
                        'updated_at'            => $now,
                    ];

                    if (count($data) >= 1000) {
                        ProductSubstitution::query()->upsert($data, ['product_id', 'substitute_id'], [
                            'created_at', 'updated_at'
                        ]);
                        $data = [];
                    }
                }

                if (!empty($data)) {
                    ProductSubstitution::query()->upsert($data, ['product_id', 'substitute_id'], [
                        'created_at', 'updated_at'
                    ]);
                }
            });
    }
}
