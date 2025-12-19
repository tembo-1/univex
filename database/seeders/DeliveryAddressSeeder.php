<?php

namespace Database\Seeders;

use App\Models\DeliveryAddress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeliveryAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeliveryAddress::query()->truncate();

        DeliveryAddress::query()->insert([
            [
                'address' => 'мкр. Востряково, ул.Вокзальная, стр. 59В',
                'working_hours' => 'пн.-вс.: с 9:00 до 20:00',
            ]
        ]);
    }
}
