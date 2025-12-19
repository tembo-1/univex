<?php

namespace App\Filament\Resources\Refunds\Schemas;

use App\Models\RefundStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;

class RefundForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Детали возврата')
                    ->description('Вся информация о заказе и клиенте')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        // Информация о клиенте
                        Fieldset::make('Контактная информация')
                            ->schema([
                                TextInput::make('user_client_short_name')
                                    ->label('Организация клиента')
                                    ->disabled()
                                    ->placeholder('Не указана')
                                    ->helperText('Юридическое название компании')
                                    ->columnSpanFull(),

                                Grid::make(2)
                                    ->columnSpanFull()
                                    ->schema([
                                        TextInput::make('user_email')
                                            ->label('Email клиента')
                                            ->disabled()
                                            ->placeholder('email@example.com')
                                            ->helperText('Основной контактный email'),

                                        TextInput::make('user_phone')
                                            ->label('Контактный телефон')
                                            ->disabled()
                                            ->placeholder('+7 (XXX) XXX-XX-XX')
                                            ->helperText('Телефон для связи'),
                                    ]),
                            ]),

                        Fieldset::make('Финансовая сводка')
                            ->schema([
                                Grid::make(2)
                                    ->columnSpanFull()
                                    ->schema([
                                        TextInput::make('total_amount')
                                            ->label('Сумма возврата')
                                            ->disabled()
                                            ->prefix('₽')
                                            ->placeholder('0.00')
                                            ->helperText('Общая сумма к возврату'),

                                        TextInput::make('quantity')
                                            ->label('Общее количество')
                                            ->disabled()
                                            ->placeholder('0')
                                            ->helperText('Всего единиц товара'),
                                    ]),
                            ]),

                        Fieldset::make('Информация по заказу')
                            ->schema([
                                Grid::make()
                                    ->columnSpanFull()
                                    ->schema([
                                        // Основная информация о заказе
                                        TextInput::make('order_id')
                                            ->label('Номер заказа')
                                            ->disabled()
                                            ->placeholder('Не указан')
                                            ->helperText('Внутренний номер заказа'),

                                        TextInput::make('order_shipping_type')
                                            ->label('Способ доставки')
                                            ->disabled()
                                            ->placeholder('Не указан')
                                            ->helperText('Самововыз, доставка'),

                                        TextInput::make('order_shipping_address')
                                            ->label('Адрес доставки')
                                            ->disabled()
                                            ->placeholder('Не указан')
                                            ->helperText('Адрес для доставки заказа'),

                                        // Временные метки
                                        TextInput::make('order_created_at')
                                            ->label('Дата создания заказа')
                                            ->disabled()
                                            ->placeholder('—')
                                            ->helperText('Когда был создан заказ'),

                                        TextInput::make('order_updated_at')
                                            ->label('Дата обновления заказа')
                                            ->disabled()
                                            ->placeholder('—')
                                            ->helperText('Дата обновления заказа'),
                                    ]),
                            ]),
                    ])
                    ->columnSpan(3),
                Section::make('Коммуникация')
                    ->description('Чат с клиентом и управление заявкой')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->schema([
                        Fieldset::make('Статус и прогресс')
                            ->schema([
                                Select::make('refund_status_id')
                                    ->label('Текущий статус заявки')
                                    ->required()
                                    ->placeholder('Выберите статус...')
                                    ->options(
                                        RefundStatus::query()->pluck('name', 'id')
                                    )
                                    ->reactive()
                                    ->columnSpanFull(),

                                Grid::make(2)
                                    ->columnSpanFull()
                                    ->schema([
                                        TextInput::make('created_at')
                                            ->label('Дата создания')
                                            ->disabled()
                                            ->formatStateUsing(fn ($record) => $record ? $record->created_at->format('d.m.Y H:i') : '—')
                                            ->placeholder('—')
                                            ->helperText('Когда заявка была создана'),

                                        TextInput::make('updated_at')
                                            ->label('Обновление')
                                            ->disabled()
                                            ->formatStateUsing(fn ($record) => $record ? $record->updated_at?->format('d.m.Y H:i') : '—')
                                            ->placeholder('—')
                                            ->helperText('Когда были внесены изменения'),
                                    ]),
                            ]),

                        Fieldset::make('Чат по возврату')
                            ->schema([
                                Livewire::make('refund-chat')
                                    ->key(fn ($record) => 'refund-chat-' . ($record?->id ?: 'new'))
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(2),

                // Левая колонка - Основная информация

            ])
            ->columns(5);
    }
}
