<?php

namespace Database\Seeders;

use App\Models\NavigationOrder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NavigationOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NavigationOrder::query()->truncate();

        $resources = [
            'content'       => 'Наполнение',
            'statistics'    => 'Статистика',
            'mailing'       => 'Рассылки',
            'editor'        => 'Редактор',
            'store'         => 'Интернет торговля',
            'callback'      => 'Обратная связь',
            'management'    => 'Управление менеджерами и организациями',
        ];

// Подготовка данных для вставки
        $data = [];
        $position = 1;

        foreach ($resources as $resource => $name) {
            $data[] = [
                'slug' => strtolower($resource), // Callbacks -> callbacks
                'name' => $name, // Русское название
                'position' => $position,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

// Вставка данных
        NavigationOrder::query()->insert($data);
    }
}
