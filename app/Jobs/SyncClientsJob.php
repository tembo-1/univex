<?php

namespace App\Jobs;

use App\Models\BankAccount;
use App\Models\Client;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class SyncClientsJob implements ShouldQueue
{
    use Queueable;

    public int $timeout = 300;

    public function handle()
    {
        $userCodes = User::query()->whereNotNull('code')->pluck('code');

        $this->processCreate($userCodes);
        $this->processUpdate($userCodes);
    }

    private function processCreate(Collection $userCodes): void
    {
        $createExternalClients = DB::connection('external')
            ->table('univexnav_customers')
            ->whereNotIn('no', $userCodes)
            ->whereNotNull('inn')
            ->whereNot('inn', '')
            ->where('rejected', 0)
            ->get();

        $clients = $this->prepareToCreate($createExternalClients);

        $this->create($clients);
    }

    private function processUpdate(Collection $userCodes): void
    {
        // 1. Предзагружаем ВСЕ данные за минимальное число запросов
        $users = User::whereIn('code', $userCodes)
            ->get(['id', 'code', 'email'])
            ->keyBy('code');

        if ($users->isEmpty()) return;

        $clientIds = $users->pluck('id');
        $clients = Client::whereIn('user_id', $clientIds)
            ->get(['id', 'user_id', 'employee_id', 'client_status_id'])
            ->keyBy('user_id');

        $bankClientIds = $clients->pluck('id');
        $bankAccounts = BankAccount::whereIn('client_id', $bankClientIds)
            ->get(['id', 'client_id'])
            ->keyBy('client_id');

        // 2. Получаем данные из внешней БД только нужных полей
        $updateExternalClients = DB::connection('external')
            ->table('univexnav_customers')
            ->whereIn('no', $userCodes)
            ->get();

        // 3. Обработка пачками по 100 записей
        foreach ($updateExternalClients->chunk(100) as $chunk) {
            $this->updateBatch($chunk, $users, $clients, $bankAccounts);
        }
    }

    private function updateBatch($chunk, $users, $clients, $bankAccounts): void
    {
        DB::transaction(function () use ($chunk, $users, $clients, $bankAccounts) {
            foreach ($chunk as $external) {
                try {
                    $user = $users->get($external->no);
                    if (!$user) continue;

                    // 1. Обновляем пользователя если email изменился
                    if ($user->email !== $external->email) {
                        User::where('id', $user->id)
                            ->update(['email' => $external->email]);
                    }

                    // 2. Обновляем или создаем клиента
                    $client = $clients->get($user->id);

                    if ($client) {
                        // Обновляем существующего клиента
                        Client::where('id', $client->id)->update([
                            'name' => $external->name,
                            'short_name' => $external->name,
                            'inn' => $external->inn,
                            'kpp' => $external->kpp,
                            'legal_address' => $external->address ?? null,
                            'postal_address' => $external->addressFact ?? null,
                            'head_name' => $external->head_name ?? null,
                            'head_position' => $external->head_position ?? null,
                            'first_name' => $external->first_name ?? null,
                            'last_name' => $external->last_name ?? null,
                            'middle_name' => $external->middle_name ?? null,
                            'phone' => $external->phoneNo ?? null,
                            'edo_operator' => $external->edo_operator ?? null,
                            'edo_identifier' => $external->edoID ?? null,
                            'updated_at' => now(),
                        ]);
                    } else {
                        // Создаем нового клиента
                        $newClient = Client::create([
                            'user_id' => $user->id,
                            'client_status_id' => 3,
                            'employee_id' => null,
                            'name' => $external->name,
                            'short_name' => $external->name,
                            'inn' => $external->inn,
                            'kpp' => $external->kpp,
                            'legal_address' => $external->address ?? null,
                            'postal_address' => $external->addressFact ?? null,
                            'head_name' => $external->head_name ?? null,
                            'head_position' => $external->head_position ?? null,
                            'first_name' => $external->first_name ?? null,
                            'last_name' => $external->last_name ?? null,
                            'middle_name' => $external->middle_name ?? null,
                            'phone' => $external->phoneNo ?? null,
                            'edo_operator' => $external->edo_operator ?? null,
                            'edo_identifier' => $external->edoID ?? null,
                        ]);

                        $clients->put($user->id, $newClient);
                    }

                    // 3. Получаем актуальный ID клиента
                    $currentClient = $clients->get($user->id);
                    if (!$currentClient) continue;

                    // 4. Банковский счет
                    $hasBankData = !empty(trim($external->bankName ?? ''))
                        || !empty(trim($external->bic ?? ''))
                        || !empty(trim($external->rassSchet ?? ''));

                    if ($hasBankData) {
                        $bankAccount = $bankAccounts->get($currentClient->id);

                        if ($bankAccount) {
                            // Обновляем существующий счет
                            BankAccount::where('id', $bankAccount->id)->update([
                                'bank_name' => $this->normalizeEmptyToNull($external->bankName),
                                'bik' => $this->normalizeEmptyToNull($external->bic),
                                'payment_account' => $this->normalizeEmptyToNull($external->rassSchet),
                                'correspondent_account' => $this->normalizeEmptyToNull($external->corrSchet),
                                'updated_at' => now(),
                            ]);
                        } else {
                            // Создаем новый счет
                            BankAccount::create([
                                'client_id' => $currentClient->id,
                                'bank_name' => $this->normalizeEmptyToNull($external->bankName),
                                'bik' => $this->normalizeEmptyToNull($external->bic),
                                'payment_account' => $this->normalizeEmptyToNull($external->rassSchet),
                                'correspondent_account' => $this->normalizeEmptyToNull($external->corrSchet),
                            ]);
                        }
                    }

                } catch (Throwable $e) {
                    logger()->error('Ошибка обновления клиента', [
                        'code' => $external->no,
                        'error' => $e->getMessage()
                    ]);
                    // Продолжаем обработку остальных записей
                }
            }
        });
    }

    private function normalizeEmptyToNull($value)
    {
        return !empty(trim($value ?? '')) ? trim($value) : null;
    }

    private function create(Collection $clients): void
    {
//        DB::transaction(function () use ($clients) {
            foreach ($clients as $data) {
                try {
                    // 1. Создаем пользователя
                    $user = User::query()
                        ->create([
                            'email' => $data['user']['email'],
                            'password' => $data['user']['password'],
                            'code' => $data['user']['code']
                        ]);

                    // 2. Создаем клиента
                    $client = Client::query()
                        ->create(array_merge(
                            $data['client'],
                            ['user_id' => $user->id]
                        ));

                    // 3. Создаем банковский счет только если есть данные
                    if (!empty($data['bankAccount'])) {
                        $hasBankData = collect($data['bankAccount'])
                            ->filter(function ($value) {
                                return !empty(trim($value ?? ''));
                            })
                            ->isNotEmpty();

                        if ($hasBankData) {
                            BankAccount::create(array_merge(
                                $data['bankAccount'],
                                ['client_id' => $client->id]
                            ));
                        }
                    }

                } catch (Throwable $exception) {
                    continue;
                }
            }
//        });
    }

    public function prepareToCreate(Collection $clients)
    {
        $managerCodes = $clients->pluck('managingpersonCode')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $employees = Employee::whereIn('code', $managerCodes)
            ->get()
            ->keyBy('code');

        return $clients->map(function ($client) use ($employees) {
            try {
                $employeeId = isset($employees[$client->managingpersonCode])
                    ? $employees[$client->managingpersonCode]->id
                    : null;

                if (!$client->email) {
                    return [];
                }

                // Очищаем банковские данные
                $bankAccount = array_filter([
                    'bank_name' => $this->normalizeEmptyToNull($client->bankName),
                    'bik' => $this->normalizeEmptyToNull($client->bic),
                    'payment_account' => $this->normalizeEmptyToNull($client->rassSchet),
                    'correspondent_account' => $this->normalizeEmptyToNull($client->corrSchet),
                ], function ($value) {
                    return $value !== null;
                });

                return [
                    'user' => [
                        'email' => $client->email,
                        'password' => $client->password,
                        'code' => $client->no
                    ],
                    'client' => [
                        'client_status_id' => 3,
                        'employee_id' => $employeeId,
                        'name' => $client->name,
                        'short_name' => $client->name,
                        'inn' => $client->inn,
                        'kpp' => $client->kpp,
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
                    'bankAccount' => $bankAccount
                ];
            } catch (Throwable) {
                return [];
            }
        })
            ->filter()
            ->values()
            ->unique('user.code');
    }
}
