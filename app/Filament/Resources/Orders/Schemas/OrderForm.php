<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Models\OrderStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('👤 Основная информация о заказе')
                    ->description('Данные о заказе и клиенте')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Section::make('Общая информация о заказе')
                            ->description('Информация по клиенту и заказу')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Fieldset::make('Информация по клиенту')
                                            ->columnSpanFull()
                                            ->schema([
                                                TextInput::make('user_client_short_name')
                                                    ->label('Организация клиента')
                                                    ->disabled()
                                                    ->placeholder('—'),

                                                TextInput::make('user_email')
                                                    ->label('Email клиента')
                                                    ->disabled()
                                                    ->placeholder('—'),

                                                TextInput::make('user_phone')
                                                    ->label('Контактный телефон')
                                                    ->disabled()
                                                    ->placeholder('—'),
                                            ])
                                    ]),
                            ])
                    ])
                    ->columnSpan(2),

                Section::make('Сводка по заказу')
                    ->description('Общая информация по данному заказу')
                    ->icon('heroicon-o-lock-closed')
                    ->schema([
                        Fieldset::make()
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('total_amount')
                                    ->label('Общая стоимость заказа')
                                    ->disabled()
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 0, '', ' ') . ' ₽' : '0 ₽')
                                    ->placeholder('0 ₽')
                                    ->columnSpanFull(),

                                TextInput::make('quantity')
                                    ->label('Общее количество позиций')
                                    ->disabled()
                                    ->placeholder('20')
                                    ->columnSpanFull(),

                                Section::make('Статусы')
                                    ->columnSpanFull()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('is_paid')
                                                    ->label('Оплачен')
                                                    ->onColor('success')
                                                    ->offColor('danger')
                                                    ->onIcon('heroicon-o-check-circle')
                                                    ->offIcon('heroicon-o-x-circle')
                                                    ->inline(false),

                                                Select::make('order_status_id')
                                                    ->options(function () {
                                                        return OrderStatus::query()
                                                            ->pluck('name', 'id');
                                                    })
                                                    ->label('Статус заказа')
                                                    ->dehydrated(fn () => auth()->user()->hasRole('Администратор'))
                                                    ->disabled(fn () => auth()->user()->hasRole('Администратор'))
                                                    ->placeholder('Неизвестный статус')
                                                    ->columnSpanFull(),
                                            ]),
                                    ]),
                            ]),
                    ])
                    ->columns(1),
            ])
            ->columns(3);
    }
}
