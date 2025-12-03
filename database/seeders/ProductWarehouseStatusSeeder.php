<?php

namespace Database\Seeders;

use App\Models\ProductWarehouseStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductWarehouseStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductWarehouseStatus::query()
            ->insert([
                [
                    'name'          => 'Складской',
                    'slug'          => 'warehouse',
                    'description'   => '',
                ],
                [
                    'name'          => 'Заказной',
                    'slug'          => 'registered',
                    'description'   => '',
                ],
                [
                    'name'          => 'Не используемый',
                    'slug'          => 'unused',
                    'description'   => '',
                ],
            ]);
    }
}
