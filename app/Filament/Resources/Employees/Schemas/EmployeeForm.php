<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Левая колонка - основные данные
                Section::make('👤 Основная информация')
                    ->description('Личные данные и контакты менеджера')
                    ->icon('heroicon-o-identification')
                    ->schema([
                        Fieldset::make('ФИО менеджера')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('last_name')
                                            ->label('Фамилия')
                                            ->required()
                                            ->maxLength(50)
                                            ->placeholder('Иванов')
                                            ->helperText('Обязательное поле')
                                            ->suffixIcon('heroicon-m-user-circle'),

                                        TextInput::make('first_name')
                                            ->label('Имя')
                                            ->required()
                                            ->maxLength(50)
                                            ->placeholder('Иван')
                                            ->helperText('Обязательное поле')
                                            ->suffixIcon('heroicon-m-user'),

                                        TextInput::make('middle_name')
                                            ->label('Отчество')
                                            ->maxLength(50)
                                            ->nullable()
                                            ->placeholder('Иванович')
                                            ->helperText('Необязательное поле')
                                            ->suffixIcon('heroicon-m-user-plus'),
                                    ]),
                            ])
                            ->columns(1),

                        Fieldset::make('Контактная информация')
                            ->schema([
                                TextInput::make('internal_phone')
                                    ->label('Внутренний телефон')
                                    ->tel()
                                    ->prefix('+7')
                                    ->mask('(999) 999-99-99')
                                    ->placeholder('(999) 123-45-67')
                                    ->helperText('Внутренний номер для связи')
                                    ->maxLength(18)
                                    ->suffixIcon('heroicon-m-phone'),

                                Textarea::make('description')
                                    ->label('Дополнительная информация')
                                    ->rows(3)
                                    ->placeholder('Обязанности, зона ответственности, комментарии...')
                                    ->helperText('Краткое описание роли менеджера')
                                    ->maxLength(500),
                            ])
                            ->columns(1),
                    ])
                    ->columnSpan(2),

                // Правая колонка - учётная запись и статус
                Section::make('🔐 Учётная запись')
                    ->description('Данные для входа в систему')
                    ->icon('heroicon-o-lock-closed')
                    ->schema([
                        Fieldset::make('Авторизация')
                            ->schema([
                                TextInput::make('email')
                                    ->label('Email адрес')
                                    ->required()
                                    ->email()
                                    ->maxLength(255)
                                    ->placeholder('manager@company.ru')
                                    ->helperText('Для входа в систему')
                                    ->suffixIcon('heroicon-m-envelope'),

                                TextInput::make('password')
                                    ->label('Пароль')
                                    ->password()
                                    ->revealable(fn () => auth()->user()->hasRole('Администратор'))
                                    ->minLength(8)
                                    ->maxLength(255)
                                    ->helperText('Минимум 8 символов. При редактировании - оставьте пустым, если не нужно менять')
                                    ->suffixIcon('heroicon-m-key')
                                    ->rules([Password::default()]),
                            ])
                            ->columns(1),

                        Fieldset::make('Роли и права')
                            ->schema([
                                Select::make('user_roles')
                                    ->label('Роли пользователя')
                                    ->required()
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->helperText('Выберите роли для этого менеджера')
                                    ->suffixIcon('heroicon-m-shield-check')
                                    ->options(function () {
                                        return Role::where('guard_name', 'admin')
                                            ->get()
                                            ->mapWithKeys(fn ($role) => [
                                                $role->id => "{$role->name} 🛡️"
                                            ])
                                            ->toArray();
                                    })
                                    ->rules(['array']),
                            ])
                            ->columns(1),

                        Fieldset::make('Статус сотрудника')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Активный сотрудник')
                                    ->default(true)
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->inline(false)
                                    ->helperText('Включите для доступа к системе, отключите для деактивации')
                                    ->onIcon('heroicon-m-eye')
                                    ->offIcon('heroicon-m-eye-slash'),
                            ])
                            ->columns(1),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }
}
