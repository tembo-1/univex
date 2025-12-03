<?php

namespace Database\Seeders;

use App\Models\CallbackType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CallbackTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CallbackType::query()
            ->insert([
                [
                    'name' => 'phone',
                ],
                [
                    'name' => 'telegram',
                ],
                [
                    'name' => 'whatsapp',
                ],
            ]);
    }
}
