<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use App\Models\Employee;
use App\Models\Client;
use App\Models\ClientStatus;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = Storage::disk('public')->get('univexnav_clients.json');
        $organizations = json_decode($json, true);

        collect($organizations[2]['data'])->skip(3)->map(function ($organization) {
            if (!$organization['Login']) {
                return;
            }

            DB::transaction(function () use ($organization) {
                try {
                    $employee = Employee::query()
                        ->firstWhere('code', $organization['ManagerpersonCode']);

                    if ($organization['Rejected'] == 1) {
                        $status = 4;
                    } else {
                        $status = 3;
                    }

                    if (!$organization['VatNo']) {
                        return;
                    }

                    $user = User::query()
                        ->create([
                            'email'     => $organization['Login'],
                            'password'  => $organization['Password'],
                            'code'  => $organization['No'],
                        ]);

                    $organizationModel = Client::query()
                        ->create([
                            'user_id'                   => $user->id,
                            'client_status_id'          => $status,
                            'employee_id'               => $employee->id ?? null,
                            'name'                      => $organization['Name1'],
                            'short_name'                => $organization['Name1'],
                            'inn'                       => $organization['VatNo'],
                            'kpp'                       => $organization['KPP'],
                            'ogrn'                      => $organization['KPP'],
                            'personal_discount'         => floatval($organization['Disc']),
                            'legal_address'             => $organization['Address'],
                            'postal_address'            => $organization['AddressFact'],
                            'phone'                     => $organization['Phone'],
                        ]);

                    BankAccount::query()
                        ->create([
                            'client_id'                 => $organizationModel->id,
                            'bank_name'                 => $organization['bName'] ?: null,
                            'bik'                       => $organization['BIC'] ?: null,
                            'payment_account'           => $organization['RasSchet'] ?: null,
                            'correspondent_account'     => $organization['CorrSchet'] ?: null,
                            'is_default'                => 1,
                        ]);
                } catch (\Throwable) {
                    return;
                }
            });
        });
    }
}
