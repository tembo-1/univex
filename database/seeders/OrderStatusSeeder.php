<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::query()
            ->insert([
                [
                    'name' => 'Новый',
                    'slug' => 'new',
                ],
                [
                    'name' => 'Обработан',
                    'slug' => 'processed',
                ]
            ]);
    }
}
