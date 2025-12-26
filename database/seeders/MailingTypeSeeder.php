<?php

namespace Database\Seeders;

use App\Models\MailingType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MailingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MailingType::query()->truncate();

        MailingType::query()->insert([
            [
                'name' => 'Отправка привязанным клиентам',
                'slug' => Str::slug('Отправка привязанным клиентам'),
            ],
            [
                'name' => 'Отправка всем клиентам',
                'slug' => Str::slug('Отправка всем клиентам'),
            ],
            [
                'name' => 'Отправка прайс-листов',
                'slug' => Str::slug('Отправка прайс-листов'),
            ]
        ]);
    }
}
