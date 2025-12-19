<?php

namespace Database\Seeders;

use App\Models\ClientLedgerEntryType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClientLedgerEntryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClientLedgerEntryType::query()->truncate();

        ClientLedgerEntryType::query()->insert([
            [
                'name' => 'оплата',
                'slug' => Str::slug('оплата'),
            ],
            [
                'name' => 'счет',
                'slug' => Str::slug('счет'),
            ],
            [
                'name' => 'кредит-нота',
                'slug' => Str::slug('кредит-нота'),
            ],
            [
                'name' => 'возмещение',
                'slug' => Str::slug('возмещение'),
            ]
        ]);
    }
}
