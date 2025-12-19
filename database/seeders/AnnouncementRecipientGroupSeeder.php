<?php

namespace Database\Seeders;

use App\Models\NotificationRecipientGroup;
use App\Models\MailingStatus;
use App\Models\NotificationType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AnnouncementRecipientGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Сначала очищаем таблицу (опционально)
        NotificationRecipientGroup::query()->truncate();
        NotificationType::query()->truncate();

        NotificationType::query()
            ->insert([
                [
                    'slug' => 'push',
                    'name' => 'Пуш уведомления',
                ],
                [
                    'slug' => 'basket',
                    'name' => 'В корзине',
                ],
                [
                    'slug' => 'personal',
                    'name' => 'Персонально в профиле',
                ]
            ]);

        // Вставляем статусы
        NotificationRecipientGroup::query()->insert([
            [
                'name' => 'Все посетители',
                'slug' => 'all',
                'description' => 'Показывать всем посетителям сайта',
            ],
            [
                'name' => 'Авторизованные пользователи',
                'slug' => 'authenticated',
                'description' => 'Только для зарегистрированных пользователей',
            ],
            [
                'name' => 'Гости',
                'slug' => 'guests',
                'description' => 'Только для неавторизованных посетителей',
            ],
            [
                'name' => 'Персональное уведомление',
                'slug' => 'personal',
                'description' => 'Персональное уведомление',
            ]
        ]);
    }
}
