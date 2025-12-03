<?php

namespace Database\Seeders;

use App\Models\DiscountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DiscountType::query()->truncate();

        DiscountType::query()
            ->insert([
                [
                    'name'          => 'Персональная скидка',
                    'slug'          => 'personal',
                    'code'          => '0',
                    'description'   => 'Персональной цены для клиента для товара или группы товаров',
                ],
                [
                    'name'          => 'Группы клиентов',
                    'slug'          => 'user_group',
                    'code'          => '1',
                    'description'   => 'Применяется совместно с группами скидки клиента',
                ],
                [
                    'name'          => 'Специальные предложения',
                    'slug'          => 'special',
                    'code'          => '2',
                    'description'   => 'Специальные предложения для всех клиентов (с указанием даты начала и конца действия специальной цены)',
                ],
                [
                    'name'          => 'Специальные предложения',
                    'slug'          => 'special_group',
                    'code'          => '3',
                    'description'   => 'Специальные предложения для группы клиентов (с указанием даты начала и конца действия специальной цены)',
                ],
            ]);
    }
}
