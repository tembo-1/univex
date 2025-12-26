<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::query()->truncate();

        $resources = [
            'Callbacks' => 'Обратные звонки',
            'Catalogs' => 'Каталоги',
            'Clients' => 'Клиенты',
            'Contacts' => 'Контакты',
            'Employees' => 'Сотрудники',
            'LoginLogs' => 'Логи входов',
            'MailingCampaigns' => 'Рассылки',
            'Manufacturers' => 'Производители',
            'ManufactureViews' => 'Просмотры производителей',
            'Menus' => 'Меню',
            'Notifications' => 'Уведомления',
            'Orders' => 'Заказы',
            'Posts' => 'Статьи',
            'Products' => 'Товары',
            'ProductViews' => 'Просмотры товаров',
            'Refunds' => 'Возвраты',
            'Roles' => 'Роли',
            'SearchViews' => 'Поисковые запросы',
            'Settings' => 'Настройки',
            'SitePages' => 'Страницы сайта',
            'Vacancies' => 'Вакансии',
            'Warehouses' => 'Склады',
            'NavigationOrder' => 'Порядок меню',
        ];

        $guardName = 'admin';

        foreach ($resources as $resource => $name) {
            $data[] = [
                'name' => strtolower($resource),
                'guard_name' => $guardName,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Permission::query()->insert($data);
    }
}
