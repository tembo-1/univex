<?php

namespace Database\Seeders;

use App\Models\MailingStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class MailingStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Сначала очищаем таблицу (опционально)
        MailingStatus::query()->truncate();

        // Вставляем статусы
        MailingStatus::query()->insert([
            [
                'name' => 'Черновик',
                'slug' => 'draft',
                'description' => 'Рассылка создана, но не готова к отправке',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Запланирована',
                'slug' => 'scheduled',
                'description' => 'Рассылка запланирована на определённое время',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Отправляется',
                'slug' => 'sending',
                'description' => 'Рассылка в процессе отправки',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Завершена',
                'slug' => 'completed',
                'description' => 'Рассылка успешно отправлена всем получателям',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Отменена',
                'slug' => 'cancelled',
                'description' => 'Рассылка отменена и не будет отправлена',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ошибка',
                'slug' => 'failed',
                'description' => 'При отправке рассылки возникли ошибки',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
