<?php

namespace Database\Seeders;

use App\Models\ClientStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClientStatus::query()->truncate();

        ClientStatus::query()->insert([
            [
                'name'  => 'Отправлена',
                'alias' => 'sent',
            ],
            [
                'name'  => 'На рассмотрении',
                'alias' => 'on_consideration',
            ],
            [
                'name'  => 'Принята',
                'alias' => 'accepted',
            ],
            [
                'name'  => 'Отклонена',
                'alias' => 'rejected',
            ],
        ]);
    }
}
