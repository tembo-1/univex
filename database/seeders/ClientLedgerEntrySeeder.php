<?php

namespace Database\Seeders;

use App\Models\ClientLedgerEntry;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ClientLedgerEntrySeeder extends Seeder
{
    public function run(): void
    {
        ClientLedgerEntry::query()->truncate();

        $json = Storage::disk('public')->get('univexnav_custledgerentry.json');
        $cle = collect(json_decode($json, true)[2]['data']);

        // Получаем пользователей по их кодам
        $users = User::query()
            ->whereIn('code', $cle->pluck('CustNo')->unique())
            ->get()
            ->keyBy('code'); // Индексируем по коду для быстрого поиска

        // Маппинг типов документов
        $docTypeMapping = [
            'Счет' => 2,           // invoice
            'Оплата' => 1,         // payment
            'Кредит-нота' => 3,    // credit_note
            'Возмещение' => 4,     // refund (у вас 4 вместо 6)
        ];

        $cle->chunk(5000)->each(function ($chunk) use ($users, $docTypeMapping) {
            $dataToInsert = [];

            foreach ($chunk as $info) {
                // Получаем пользователя
                $user = $users[$info['CustNo']] ?? null;

                if (!$user) {
                    continue; // Пропускаем если пользователь не найден
                }

                // Определяем тип документа
                $docType = $info['DocType'] ?? 'Счет';
                $status = $docTypeMapping[$docType] ?? 2;

                // Определяем positive с точки зрения клиента
                // Для клиента: Оплата (+) true, Счет (-) false, Кредит-нота (+) true, Возмещение (-) false
                if ($docType === 'Оплата' || $docType === 'Кредит-нота') {
                    $positive = true; // Положительные операции для клиента
                } else {
                    $positive = false; // Отрицательные операции для клиента
                }

                // Корректируем сумму с точки зрения клиента
                // Внешняя система: счет (+), оплата (-)
                // Нам нужно: счет (-), оплата (+)
                $amount = (int) $info['Amount'];

                if ($docType === 'Счет' || $docType === 'Возмещение') {
                    // Инвертируем знак для счетов и возмещений
                    $amount = -$amount;
                }

                // Обработка дат
                $postingDate = $this->parseDate($info['PostingDate']);
                $dueDate = $this->parseDate($info['DueDate']);

                // Формируем запись
                $dataToInsert[] = [
                    'client_ledger_entry_type_id' => $status,
                    'user_id' => $user->id,
                    'entry_number' => $info['DocNo'] ?? 'N/A',
                    'posting_date' => $postingDate,
                    'document_no' => $info['DocNo'] ?? '',
                    'due_date' => $dueDate,
                    'positive' => $positive,
                    'open' => (bool) ($info['Open'] ?? false),
                    'amount' => $amount,
                    'remaining_amount' => (int) ($info['RemainingAmount'] ?? 0),
                    'description' => $docType . ' ' . ($info['DocNo'] ?? ''),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if (!empty($dataToInsert)) {
                ClientLedgerEntry::query()->insert($dataToInsert);
            }
        });

        $this->command->info('Импортировано ' . ClientLedgerEntry::count() . ' записей');
    }

    private function parseDate($dateString)
    {
        if (empty($dateString) ||
            $dateString === '0000-00-00 00:00:00' ||
            $dateString === '0000-00-00') {
            return null;
        }

        try {
            return date('Y-m-d', strtotime($dateString));
        } catch (\Exception $e) {
            return null;
        }
    }
}
