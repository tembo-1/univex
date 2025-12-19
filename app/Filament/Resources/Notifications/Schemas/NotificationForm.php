<?php

namespace App\Filament\Resources\Notifications\Schemas;

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
                                            ->placeholder('Детальное описание изменения или важной информации...')
                                            ->helperText('Можно использовать Markdown для форматирования')
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Получатели')
                            ->icon('heroicon-o-user-group')
                            ->schema([
                                Section::make('Выбор получателей')
                                    ->description('Укажите, кто должен получить это уведомление')
                                    ->schema([
                                        ToggleButtons::make('recipient_selection_mode')
                                            ->label('Режим выбора получателей')
                                            ->options([
                                                'group' => 'По группе',
                                                'specific' => 'Конкретные пользователи',
                                            ])
                                            ->default('group')
                                            ->inline()
                                            ->grouped()
                                            ->dehydrated(false)
                                            ->reactive()
                                            // Определяем режим при загрузке данных
                                            ->afterStateHydrated(function (ToggleButtons $component, $state, $record) {
                                                if ($record) {
                                                    // Если есть конкретные пользователи - режим specific
                                                    if ($record->users()->exists()) {
                                                        $component->state('specific');
                                                    }
                                                    // Если выбрана группа - режим group
                                                    elseif ($record->notification_recipient_group_id) {
                                                        $component->state('group');
                                                    }
                                                }
                                            }),

                                        Grid::make()
                                            ->schema(fn ($get) => match ($get('recipient_selection_mode')) {
                                                'group' => [
                                                    Select::make('notification_recipient_group_id')
                                                        ->label('Группа получателей')
                                                        ->relationship('notificationRecipientGroup', 'name')
                                                        ->searchable()
                                                        ->preload()
                                                        ->native(false)
                                                        ->placeholder('Выберите группу')
                                                        ->helperText('Все пользователи из выбранной группы получат уведомление')
                                                        ->columnSpanFull()
                                                        ->required(fn ($get) => $get('recipient_selection_mode') === 'group'),
                                                ],
                                                'specific' => [
                                                    Select::make('selected_users')
                                                        ->label('Выберите пользователей')
                                                        ->multiple()
                                                        ->options(function () {
                                                            return User::query()
                                                                ->get()
                                                                ->mapWithKeys(fn (User $user) => [
                                                                    $user->id => "{$user->email}"
                                                                ]);
                                                        })
                                                        ->searchable()
                                                        ->preload()
                                                        ->native(false)
                                                        ->placeholder('Начните вводить имя или email')
                                                        ->helperText('Можно выбрать несколько пользователей')
                                                        ->columnSpanFull()
                                                        // ВАЖНО: это поле не должно сохраняться в таблицу notifications
                                                        ->dehydrated(false)
                                                        ->rules([
                                                            'required_if:recipient_selection_mode,specific',
                                                            'array',
                                                            'min:1',
                                                        ])
                                                        ->afterStateHydrated(function (Select $component, $state, $record) {
                                                            if ($record && $record->users()->exists()) {
                                                                $component->state($record->users->pluck('id')->toArray());
                                                            }
                                                        }),
                                                ],
                                                default => [],
                                            })
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Расписание')
                            ->icon('heroicon-o-calendar')
                            ->schema([
                                Section::make('Время отображения')
                                    ->description('Настройте когда показывать уведомление')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                DateTimePicker::make('starts_at')
                                                    ->label('Начало показа')
                                                    ->displayFormat('d.m.Y H:i')
                                                    ->timezone('Europe/Moscow')
                                                    ->placeholder('Сразу после сохранения')
                                                    ->helperText('Если не указано - показывать сразу')
                                                    ->minDate(now())
                                                    ->weekStartsOnMonday(),

                                                DateTimePicker::make('ends_at')
                                                    ->label('Окончание показа')
                                                    ->displayFormat('d.m.Y H:i')
                                                    ->timezone('Europe/Moscow')
                                                    ->placeholder('Бессрочно')
                                                    ->helperText('Если не указано - показывать бессрочно')
                                                    ->minDate(fn ($get) => $get('starts_at') ?? now())
                                                    ->weekStartsOnMonday(),
                                            ]),

                                        Grid::make(2)
                                            ->schema([
                                                Toggle::make('is_active')
                                                    ->label('Активно')
                                                    ->default(true)
                                                    ->inline()
                                                    ->onColor('success')
                                                    ->offColor('danger')
                                                    ->helperText('Можно временно отключить'),

                                                Select::make('show_again_after')
                                                    ->label('Повторный показ')
                                                    ->options([
                                                        null => 'Никогда не показывать снова',
                                                        3600 => 'Через 1 час',
                                                        10800 => 'Через 3 часа',
                                                        86400 => 'Через 24 часа',
                                                        604800 => 'Через 7 дней',
                                                        2592000 => 'Через 30 дней',
                                                    ])
                                                    ->native(false)
                                                    ->helperText('После закрытия пользователем')
                                                    ->placeholder('Выберите интервал'),
                                            ]),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Классификация')
                            ->icon('heroicon-o-tag')
                            ->schema([
                                Section::make('Категоризация уведомления')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                Select::make('notification_type_id')
                                                    ->label('Тип уведомления')
                                                    ->relationship('notificationType', 'name')
                                                    ->required()
                                                    ->searchable()
                                                    ->preload()
                                                    ->native(false)
                                                    ->placeholder('Выберите тип')
                                                    ->helperText('Определяет иконку и цвет'),
                                            ]),
                                    ])
                                    ->collapsible(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }
}
