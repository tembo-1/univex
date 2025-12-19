<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Контакт')
                    ->tabs([
                        Tabs\Tab::make('Основная информация')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('Данные контакта')
                                    ->description('Основная информация о сотруднике')
                                    ->schema([
                                        Grid::make()
                                            ->schema([
                                                Fieldset::make('Личные данные')
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                TextInput::make('name')
                                                                    ->label('ФИО')
                                                                    ->required()
                                                                    ->maxLength(255)
                                                                    ->placeholder('Иванов Иван Иванович')
                                                                    ->columnSpan(2),
                                                            ]),
                                                    ])
                                                    ->columns(1),

                                                Fieldset::make('Контактная информация')
                                                    ->schema([
                                                        Grid::make(2)
                                                            ->schema([
                                                                TextInput::make('phone')
                                                                    ->label('Телефон')
                                                                    ->required()
                                                                    ->maxLength(255)
                                                                    ->placeholder('+7 (999) 123-45-67')
                                                                    ->helperText('Формат: +7 (XXX) XXX-XX-XX'),

                                                                TextInput::make('email')
                                                                    ->label('Email')
                                                                    ->email()
                                                                    ->required()
                                                                    ->maxLength(255)
                                                                    ->placeholder('ivanov@company.com')
                                                                    ->helperText('Корпоративная почта'),
                                                            ]),
                                                    ])
                                                    ->columns(1),
                                            ]),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tabs\Tab::make('Расписание и отдел')
                            ->icon('heroicon-o-clock')
                            ->schema([
                                Section::make('Рабочее время и принадлежность')
                                    ->schema([
                                        Grid::make()
                                            ->schema([
                                                Fieldset::make('График работы')
                                                    ->schema([
                                                        TextInput::make('working_hours')
                                                            ->label('Рабочие часы')
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->placeholder('Пн-Пт, 9:00-18:00')
                                                            ->helperText('Укажите рабочие дни и время')
                                                            ->columnSpanFull(),
                                                    ])
                                                    ->columns(1),

                                                Fieldset::make('Принадлежность к отделу')
                                                    ->schema([
                                                        Select::make('contact_group_id')
                                                            ->label('Подразделение')
                                                            ->relationship('contactGroup', 'name')
                                                            ->required()
                                                            ->preload()
                                                            ->searchable()
                                                            ->placeholder('Выберите отдел')
                                                            ->helperText('К какому отделу относится сотрудник')
                                                            ->columnSpanFull(),
                                                    ])
                                                    ->columns(1),
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
