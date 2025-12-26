<?php

namespace App\Filament\Resources\MailingCampaigns\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MailingCampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Основная информация')
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Название кампании')
                                    ->placeholder('Пример: Новогодняя рассылка 2024')
                                    ->helperText('Краткое и понятное название кампании')
                                    ->columnSpan(['md' => 2]),

                                Select::make('mailing_status_id')
                                    ->relationship('mailingStatus', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->label('Статус')
                                    ->helperText('Выберите текущий статус')
                                    ->native(false)
                                    ->columnSpan(['md' => 1]),

                                Select::make('mailing_type_id')
                                    ->relationship('mailingType', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->label('Тип')
                                    ->helperText('Выберите тип рассылки')
                                    ->native(false)
                                    ->columnSpan(['md' => 1]),
                            ])
                            ->columns(['md' => 3]),
                    ])
                    ->icon('heroicon-o-information-circle'),

                Section::make('Контент письма')
                    ->schema([
                        TextInput::make('subject')
                            ->required()
                            ->maxLength(255)
                            ->label('Тема письма')
                            ->placeholder('Пример: Специальное предложение для вас!')
                            ->helperText(function (callable $get) {
                                $length = strlen($get('subject') ?? '');
                                $warning = $length > 50 ? ' (Рекомендуется до 50 символов)' : '';
                                return "Длина: {$length}/255{$warning}";
                            })
                            ->live(debounce: 500),

                        RichEditor::make('content')
                            ->required()
                            ->label('Содержимое письма')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'link', 'bulletList', 'orderedList',
                                'blockquote', 'h1', 'h2', 'h3',
                            ])
                            ->fileAttachmentsDisk('local')
                            ->fileAttachmentsDirectory('mailing-attachments')
                            ->helperText('Используйте HTML разметку для форматирования')
                            ->columnSpanFull()
                            ->extraInputAttributes([
                                'style' => 'min-height: 250px'
                            ]),
                    ])
                    ->icon('heroicon-o-envelope'),

                Section::make('Настройки отправки')
                    ->schema([
                        Grid::make()
                            ->schema([
                                DateTimePicker::make('scheduled_at')
                                    ->nullable()
                                    ->label('Запланировать отправку')
                                    ->helperText(function (callable $get) {
                                        if (!$get('scheduled_at')) {
                                            return 'Отправить сразу после сохранения';
                                        }
                                        return 'Отправка по расписанию';
                                    })
                                    ->prefixIcon('heroicon-o-clock')
                                    ->seconds(false)
                                    ->weekStartsOnMonday()
                                    ->displayFormat('d.m.Y H:i')
                                    ->columnSpan(['md' => 2]),
                            ])
                            ->columns(['md' => 3]),

                        Select::make('send_again_after')
                            ->label('Повторная отправка')
                            ->nullable()
                            ->helperText('Через сколько времени повторно отправить получателям, которые не открыли письмо')
                            ->options([
                                null => 'Не отправлять повторно',
                                3600 => 'Через 1 час',
                                10800 => 'Через 3 часа',
                                86400 => 'Через 1 день',
                                259200 => 'Через 3 дня',
                                604800 => 'Через 7 дней',
                                2592000 => 'Через 30 дней',
                            ])
                            ->placeholder('Выберите интервал')
                            ->native(false)
                            ->columnSpanFull(),
                    ])
                    ->icon('heroicon-o-paper-airplane'),
            ])->columns(1);
    }
}
