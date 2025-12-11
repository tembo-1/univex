<?php

namespace App\Filament\Resources\Notifications\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Основное')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Заголовок')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Кратко и понятно')
                                    ->columnSpanFull(),

                                Textarea::make('content')
                                    ->label('Текст уведомления')
                                    ->required()
                                    ->rows(5)
                                    ->placeholder('Полное описание...')
                                    ->helperText('Будет отображаться под заголовком')
                                    ->columnSpanFull(),
                            ]),

                        Tab::make('Время показа')
                            ->icon('heroicon-o-calendar')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        DateTimePicker::make('starts_at')
                                            ->label('Дата начала')
                                            ->displayFormat('d.m.Y H:i')
                                            ->timezone('Europe/Moscow')
                                            ->placeholder('Не указана')
                                            ->helperText('Укажите, если не сразу'),

                                        DateTimePicker::make('ends_at')
                                            ->label('Дата окончания')
                                            ->displayFormat('d.m.Y H:i')
                                            ->timezone('Europe/Moscow')
                                            ->placeholder('Не указана')
                                            ->helperText('Укажите, если не бессрочно'),
                                    ]),

                                Toggle::make('is_active')
                                    ->label('Включено сейчас')
                                    ->default(true)
                                    ->inline()
                                    ->onColor('success')
                                    ->offColor('gray')
                                    ->helperText('Отключите, чтобы временно скрыть уведомление'),
                            ]),

                        Tab::make('Настройки')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Select::make('notification_recipient_group_id')
                                            ->label('Группа получателей')
                                            ->relationship('notificationRecipientGroup', 'name')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->native(false)
                                            ->placeholder('Выберите группу'),

                                        Select::make('notification_type_id')
                                            ->label('Тип уведомления')
                                            ->relationship('notificationType', 'name')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->native(false)
                                            ->placeholder('Выберите тип'),
                                    ]),

                                Select::make('show_again_after')
                                    ->label('Повторный показ')
                                    ->options([
                                        null => 'Никогда не показывать снова',
                                        60 => 'Показать через 1 час',
                                        86400 => 'Показать через 24 часа',
                                        604800 => 'Показать через 7 дней',
                                        2592000 => 'Показать через 30 дней',
                                    ])
                                    ->native(false)
                                    ->helperText('После закрытия пользователем'),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }
}
