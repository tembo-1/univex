<?php

namespace Database\Seeders;

use App\Models\RefundType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RefundTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RefundType::query()
            ->insert([
                [
                    'name' => 'Брак'
                ],
                [
                    'name' => 'Некомплектность'
                ]
            ]);
    }
}
