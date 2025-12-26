<?php

namespace App\Jobs;

use App\Models\BankAccount;
use App\Models\Client;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class SyncClientsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 3600;

    public function handle()
    {
        $externalClients = DB::connection('external')
            ->table('univexnav_customers')
            ->whereNotNull('inn')
            ->whereNotNull('bankName')
            ->whereNot('bankName', '')
            ->whereNotNull('bic')
            ->whereNotNull('address')
            ->whereNotNull('password')
            ->get();

        if ($externalClients->isEmpty()) {
            return;
        }

        $clientsData = $this->prepareClientsData($externalClients);

        DB::transaction(function () use ($clientsData) {
            $usersData = $clientsData->map(fn($data) => $data['user'])->toArray();
            User::upsert($usersData, ['code'], ['email', 'password', 'updated_at']);

            $userIds = User::whereIn('code', $clientsData->pluck('user.code'))
                ->pluck('id', 'code')
                ->toArray();

            // 3. UPSERT Clients по user_id (уникальный!)
            $clientsUpsert = $clientsData
                ->filter(fn($data) => isset($userIds[$data['user']['code']]))
                ->map(function ($data) use ($userIds) {
                    $userId = $userIds[$data['user']['code']];
                    return array_merge($data['client'], ['user_id' => $userId]);
                })
                ->toArray();

            if (!empty($clientsUpsert)) {
                Client::upsert($clientsUpsert, ['user_id'], [
                    'client_status_id', 'employee_id',
                    'personal_discount', 'name', 'short_name',
                    'inn', 'kpp', 'ogrn',
                    'marketing_email', 'is_send_price_list', 'is_send_bulk_price_list',
                    'payment_terms', 'is_store', 'discount_allow',
                    'agreement_number', 'agreement_date',
                    'legal_address', 'postal_address',
                    'head_name', 'head_position',
                    'first_name', 'last_name', 'middle_name',
                    'phone', 'edo_operator', 'edo_identifier',
                    'updated_at'
                ]);
            }

            // 4. UPSERT BankAccounts
            $this->upsertBankAccounts($clientsData, $userIds);
        });
    }

    private function prepareClientsData($externalClients): Collection
    {
        $managerCodes = $externalClients->pluck('managingpersonCode')->filter()->unique();
        $employees = Employee::whereIn('code', $managerCodes)->pluck('id', 'code');

        return $externalClients
            ->filter(fn($c) => $c->email)
            ->map(function ($client) use ($employees) {
                $status = $client->rejected ? 4 : 3;


                return [
                    'user' => [
                        'code' => $client->no,
                        'email' => $client->email,
                        'password' => Hash::make($client->password)
                    ],
                    'client' => [
                        'client_status_id' => $status,
                        'employee_id' => $employees[$client->managingpersonCode] ?? null,
                        'personal_discount' => $client->discount ?? 0.00,
                        'name' => $client->name,
                        'short_name' => $client->name,
                        'inn' => $client->inn,
                        'kpp' => $client->kpp,
                        'ogrn' => $client->ogrn ?? null,
                        'marketing_email' => $client->emailNewsletter,
                        'is_send_price_list' => $client->sendPrice ?? 0,
                        'is_send_bulk_price_list' => $client->sendManyPrice ?? 0,
                        'payment_terms' => $client->paymentTerms,
                        'is_store' => $client->onlineStore ?? 0,
                        'discount_allow' => $client->salediscountAllow ?? 0,
                        'agreement_number' => $client->agreementNo,
                        'agreement_date' => $client->agreementDate ?? null,
                        'legal_address' => $client->address ?? null,
                        'postal_address' => $client->addressFact ?? null,
                        'head_name' => $client->head_name ?? null,
                        'head_position' => $client->head_position ?? null,
                        'first_name' => $client->first_name ?? null,
                        'last_name' => $client->last_name ?? null,
                        'middle_name' => $client->middle_name ?? null,
                        'phone' => $client->phoneNo ?? null,
                        'edo_operator' => $client->edo_operator ?? null,
                        'edo_identifier' => $client->edoID ?? null,
                    ],
                    'bankAccount' => $this->prepareBankData($client)
                ];
            });
    }

    private function prepareBankData($client): array  // ✅ Обязательный массив
    {
        return [
            'bank_name' => $this->normalizeEmptyToNull($client->bankName),
            'bik' => $this->normalizeEmptyToNull($client->bic),
            'payment_account' => $this->normalizeEmptyToNull($client->rassSchet),
            'correspondent_account' => $this->normalizeEmptyToNull($client->corrSchet),
        ];
    }


    private function upsertBankAccounts(Collection $clientsData, array $userIds): void
    {
        $bankData = $clientsData
            ->filter(fn($data) => isset($userIds[$data['user']['code']]))
            ->map(function ($data) use ($userIds) {
                $userId = $userIds[$data['user']['code']];
                $clientId = Client::where('user_id', $userId)->value('id');

                if (!$clientId) return null;

                $bankAccount = $data['bankAccount'];

                // ✅ Проверяем, есть ли хоть одно непустое поле
                if (collect($bankAccount)->filter()->isEmpty()) {
                    return null;
                }

                return array_merge($bankAccount, [
                    'client_id' => $clientId,
                    'is_default' => true
                ]);
            })
            ->filter()
            ->values()
            ->toArray();

        if (!empty($bankData)) {
            BankAccount::upsert($bankData, ['client_id'], [
                'bank_name', 'bik', 'payment_account',
                'correspondent_account', 'is_default',
                'updated_at'
            ]);
        }
    }

    private function normalizeEmptyToNull($value): ?string
    {
        $trimmed = trim($value ?? '');
        return $trimmed !== '' ? $trimmed : null;
    }
}
