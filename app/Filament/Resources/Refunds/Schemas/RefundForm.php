<?php

namespace App\Filament\Resources\Refunds\Schemas;

use App\Models\RefundStatus;
use Filament\Forms\Components\Placeholder;
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
use Illuminate\Support\Facades\Storage;
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
                                Livewire::make('components.blocks.refund-chat')
                                    ->key(fn ($record) => 'refund-chat-' . ($record?->id ?: 'new'))
                                    ->columnSpanFull(),

                                Placeholder::make('chat_photos')
                                    ->label('Прикрепленные фото')
                                    ->content(function ($get) {
                                        $refundId = $get('../../id') ?? 1;
                                        $files = Storage::disk('documents')->files("refunds/$refundId/photos");

                                        if (empty($files)) {
                                            return new HtmlString('<div class="text-gray-400 text-sm italic p-3 text-center">Нет фото</div>');
                                        }

                                        $html = '<div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-2" style="display: flex">';
                                        foreach ($files as $file) {
                                            $imageUrl = "http://localhost:3377/documents/$file";

                                            $html .= '<a href="' . $imageUrl . '" target="_blank" class="group relative block w-full h-16 rounded-lg overflow-hidden shadow-sm hover:shadow-md hover:scale-[1.02] transition-all duration-200 bg-white border hover:border-blue-200 focus:outline-none focus:ring-1 focus:ring-blue-400">';

                                            $html .= '<img src="' . $imageUrl . '" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" style="height:200px"> ';

                                            // ✅ Компактная подпись только на hover
                                            $html .= '<div class="absolute inset-0 bg-gradient-to-t from-black/60 opacity-0 group-hover:opacity-100 transition-all flex items-end p-1">';
                                            $html .= '<span class="text-white text-xs truncate leading-tight">' . basename($file) . '</span>';
                                            $html .= '</div>';

                                            $html .= '</a>';
                                        }
                                        $html .= '</div>';

                                        return new HtmlString($html);
                                    })
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(2),

                // Левая колонка - Основная информация

            ])
            ->columns(5);
    }
}
