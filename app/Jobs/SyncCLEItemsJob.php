<?php

namespace App\Jobs;

use App\Models\ClientLedgerEntry;
use App\Models\ClientLedgerEntryItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class SyncCLEItemsJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 3600;

    public function handle(): void
    {
        $this->syncCLEItems();
    }

    public function syncCLEItems()
    {
        // Предзагружаем связи
        $products = Product::query()
            ->whereNotNull('code')
            ->pluck('id', 'code')
            ->toArray();

        // documentNo → entry_id (из client_ledger_entries)
        $entries = ClientLedgerEntry::pluck('id', 'document_no')->toArray();

        if (empty($products) || empty($entries)) {
            return;
        }

        $now = now();

        DB::connection('external')
            ->table('univexnav_custledgerentrylines')
            ->whereNotNull('documentNo')
            ->whereNotNull('lineNo')
            ->whereNotNull('idSite')
            ->orderBy('documentNo')
            ->orderBy('lineNo')
            ->chunk(2000, function ($batch) use ($entries, $products, $now) {
                $data = [];

                foreach ($batch as $row) {
                    $entryId = $entries[$row->documentNo] ?? null;
                    if (!$entryId) continue;

                    $productSku = $row->idSite ?? $row->no ?? null;
                    if (!$productSku) continue;

                    $data[] = [
                        'client_ledger_entry_id' => $entryId,
                        'line_no' => (int) $row->lineNo,
                        'product_sku' => $productSku,
                        'product_name' => $row->description ?? '',
                        'quantity' => (int) round((float) ($row->quantity ?? 0)),
                        'unit_price' => $this->priceToKopecks(($row->unitPrice ?? 0)),
                        'total_amount' => $this->priceToKopecks($row->amount ?? 0),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                foreach (array_chunk($data, 1000) as $chunk) {
                    ClientLedgerEntryItem::upsert($chunk,
                        ['client_ledger_entry_id', 'line_no'],
                        [
                            'product_sku', 'product_name', 'quantity',
                            'unit_price', 'total_amount', 'updated_at'
                        ]
                    );
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
