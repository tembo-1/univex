<?php

namespace Database\Seeders;

use App\Models\ShippingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShippingType::query()
            ->insert([
                [
                    'name' => 'Самовывоз',
                ],
                [
                    'name' => 'С доставкой',
                ]
            ]);
    }
}
