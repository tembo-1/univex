<?php

namespace App\Filament\Resources\WareHouses\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WareHouseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Левая колонка - основная информация
                Section::make('🏢 Основная информация')
                    ->description('Название, контакты и описание склада')
                    ->icon('heroicon-o-building-office')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Название склада')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(debounce: 500)
                                    ->placeholder('Омега')
                                    ->helperText('Уникальное название для идентификации склада')
                                    ->suffixIcon('heroicon-m-building-storefront'),

                                TextInput::make('slug')
                                    ->label('Наименование для отображения клиенту')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('Название для отображения клиенту')
                                    ->placeholder('Филиал 30')
                                    ->suffixIcon('heroicon-m-link'),
                            ]),

                        TextInput::make('email')
                            ->label('Email склада')
                            ->email()
                            ->maxLength(255)
                            ->nullable()
                            ->placeholder('warehouse@company.com')
                            ->helperText('Контактный email для уведомлений и связи')
                            ->suffixIcon('heroicon-m-envelope'),

                        Textarea::make('description')
                            ->label('Описание склада')
                            ->nullable()
                            ->rows(3)
                            ->placeholder('Основной склад компании в Москве. Хранение товаров категорий A и B. Работаем с 9:00 до 18:00.')
                            ->helperText('Дополнительная информация о назначении, режиме работы и особенностях склада')
                            ->maxLength(1000),
                    ])
                    ->columnSpan(2),

                // Правая колонка - статус
                Section::make('⚙️ Статус и видимость')
                    ->description('Активность и доступность склада')
                    ->icon('heroicon-o-cog')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Склад активен')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger')
                            ->inline(false)
                            ->helperText('Активные склады доступны для работы и отображаются в системе')
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}
