<?php

namespace App\Filament\Resources\Notifications\Schemas;

use App\Models\Client;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class NotificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Tabs::make('Уведомление')
                    ->tabs([
                        Tab::make('Содержание')
                            ->icon('heroicon-o-chat-bubble-bottom-center-text')
                            ->schema([
                                Section::make('Текст уведомления')
                                    ->description('Заголовок и содержание сообщения')
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Заголовок')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Важное обновление системы')
                                            ->helperText('Будет выделен жирным шрифтом')
                                            ->columnSpanFull(),

                                        Textarea::make('content')
                                            ->label('Текст уведомления')
                                            ->required()
                                            ->rows(6)
                                            ->placeholder('Детальное описание изменения...')
                                            ->helperText('Можно использовать Markdown')
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Получатели')
                            ->icon('heroicon-o-user-group')
                            ->schema([
                                Section::make('Выбор получателей')
                                    ->description('Укажите, кто должен получить уведомление')
                                    ->schema([
                                        Tabs::make('Режим выбора')
                                            ->tabs([
                                                Tab::make('По группе')
                                                    ->icon('heroicon-o-users')
                                                    ->schema([
                                                        Select::make('notification_recipient_group_id')
                                                            ->label('Группа получателей')
                                                            ->relationship('notificationRecipientGroup', 'name')
                                                            ->searchable()
                                                            ->preload()
                                                            ->native(false)
                                                            ->placeholder('Выберите группу')
                                                            ->required()
                                                            ->live() // ✅ live() для отслеживания изменений
                                                            ->afterStateUpdated(function ($state, callable $set) {
                                                                // ✅ Если выбрана группа с id=4, активируем второй таб
                                                                if ($state == 4) {
                                                                    $set('show_specific_users_tab', true);
                                                                }
                                                            })
                                                            ->columnSpanFull(),
                                                    ]),

                                                Tab::make('Конкретные клиенты')
                                                    ->icon('heroicon-o-user')
                                                    ->disabled(fn (callable $get): bool => !($get('notification_recipient_group_id') == 4))
                                                    ->schema([
                                                        Select::make('selected_users')
                                                            ->label('Конкретные клиенты')
                                                            ->multiple()
                                                            ->options(fn() => Client::limit(500)->pluck('name', 'user_id')->toArray())
                                                            ->placeholder('Выберите клиентов')
                                                            ->required(fn (callable $get): bool => $get('notification_recipient_group_id') == 4)
                                                            ->searchable()
                                                            ->columnSpanFull(),
                                                    ]),
                                            ])
                                            ->persistTabInQueryString()
                                            ->columnSpanFull(),
                                    ]),
                            ]),

                        Tab::make('Расписание')
                            ->icon('heroicon-o-calendar')
                            ->schema([
                                Section::make('Время отображения')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                DateTimePicker::make('starts_at')
                                                    ->label('Начало показа')
                                                    ->displayFormat('d.m.Y H:i')
                                                    ->timezone('Europe/Moscow')
                                                    ->placeholder('Сразу')
                                                    ->minDate(now())
                                                    ->weekStartsOnMonday(),

                                                DateTimePicker::make('ends_at')
                                                    ->label('Окончание показа')
                                                    ->displayFormat('d.m.Y H:i')
                                                    ->timezone('Europe/Moscow')
                                                    ->placeholder('Бессрочно')
                                                    ->minDate(fn ($get) => $get('starts_at') ?? now())
                                                    ->weekStartsOnMonday(),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('is_active')
                                                    ->label('Активно')
                                                    ->default(true)
                                                    ->helperText('Временно отключить'),

                                                Select::make('show_again_after')
                                                    ->label('Повторный показ')
                                                    ->options([
                                                        null => 'Никогда',
                                                        3600 => '1 час',
                                                        10800 => '3 часа',
                                                        86400 => '24 часа',
                                                        604800 => '7 дней',
                                                        2592000 => '30 дней',
                                                    ])
                                                    ->placeholder('Выберите интервал'),
                                            ]),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Классификация')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Section::make('Тип уведомления')
                                    ->schema([
                                        Select::make('notification_type_id')
                                            ->label('Тип уведомления')
                                            ->relationship('notificationType', 'name')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->native(false)
                                            ->placeholder('Выберите тип'),
                                    ])
                                    ->collapsible(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
