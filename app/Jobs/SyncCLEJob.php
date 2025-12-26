<?php

namespace App\Jobs;

use App\Models\ClientLedgerEntry;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class SyncCLEJob implements ShouldQueue
{
    use Queueable;

    public $timeout = 3600;

    public function handle(): void
    {
        $this->syncCLE();
    }

    public function syncCLE()
    {
        $users = User::query()
            ->whereNotNull('code')
            ->pluck('id', 'code')
            ->toArray();

        if (empty($users)) {
            return;
        }

        $now = now();

        DB::connection('external')
            ->table('univexnav_custledgerentry')
            ->whereNotNull('entryNo')
            ->whereNotNull('custNo')
            ->whereNotNull('documentType')
            ->whereIn('custNo', array_keys($users))
            ->orderBy('entryNo')
            ->chunk(2000, function ($batch) use ($users, $now) {
                $data = [];

                foreach ($batch as $row) {
                    $userKey = $row->custNo;
                    if (empty($userKey) || !isset($users[$userKey])) {
                        continue;
                    }

                    $data[] = [
                        'client_ledger_entry_type_id' => $this->getEntryTypeId($row->documentType ?? 0),
                        'user_id' => $users[$userKey],
                        'entry_no' => $row->entryNo,
                        'document_no' => $row->documentNo ?? '',
                        'posting_date' => $row->postingDate ?
                            \Carbon\Carbon::parse($row->postingDate) : null,
                        'due_date' => $row->dueDate ?
                            \Carbon\Carbon::parse($row->dueDate) : null,
                        'positive' => (bool) $row->positive,
                        'open' => (bool) $row->open,
                        'amount' => $this->priceToKopecks(($row->amount ?? 0)),
                        'remaining_amount' => $this->priceToKopecks(($row->remainingAmount ?? 0)),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                // Батчи по 1000 для upsert
                foreach (array_chunk($data, 1000) as $chunk) {
                    ClientLedgerEntry::upsert($chunk,
                        ['user_id', 'entry_no'],
                        [
                            'client_ledger_entry_type_id', 'document_no',
                            'posting_date', 'due_date', 'positive', 'open',
                            'amount', 'remaining_amount', 'updated_at'
                        ]
                    );
                }
            });
    }

    private function getEntryTypeId($documentType): int
    {
        // Маппинг типов документов (пример)
        $typeMap = [
            1 => 1,  // Invoice
            2 => 2,  // Credit Memo
            3 => 3,  // Payment
            6 => 4,  // Payment
        ];

        return $typeMap[$documentType] ?? 1; // default = Invoice
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
