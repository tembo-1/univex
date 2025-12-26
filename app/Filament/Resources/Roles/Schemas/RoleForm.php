<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ✅ Основная информация
                Section::make('Основная информация')
                    ->schema([
                        TextInput::make('name')
                            ->label('Название роли')
                            ->required()
                            ->placeholder('Администратор, Менеджер...')
                            ->columnSpan(1),
                    ])
                    ->compact()
                    ->columnSpanFull(),

                // ✅ Права доступа (группировка)
                Section::make('Права доступа')
                    ->description('Выберите права для этой роли')
                    ->schema([
                        Select::make('permissions')
                            ->label('Доступные ресурсы')
                            ->multiple()
                            ->options([
                                'callbacks' => 'Обратные звонки',
                                'catalogs' => 'Каталоги',
                                'clients' => 'Клиенты',
                                'contacts' => 'Контакты',
                                'employees' => 'Сотрудники',
                                'loginlogs' => 'Логи входов',
                                'mailingcampaigns' => 'Рассылки',
                                'manufacturers' => 'Производители',
                                'manufactureviews' => 'Просмотры производителей',
                                'menus' => '☰ Меню',
                                'notifications' => 'Уведомления',
                                'orders' => 'Заказы',
                                'posts' => 'Статьи',
                                'products' => 'Товары',
                                'productviews' => 'Просмотры товаров',
                                'refunds' => '↩Возвраты',
                                'roles' => 'Роли',
                                'searchviews' => 'Поисковые запросы',
                                'settings' => '⚙Настройки',
                                'sitepages' => 'Страницы сайта',
                                'vacancies' => 'Вакансии',
                                'warehouses' => 'Склады',
                                'navigationorder' => 'Порядок меню',
                            ])
                            ->searchable()
                            ->preload()
                            ->columns(4)
                            ->placeholder('Начните вводить название ресурса...')
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
