<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    self::organizationSection(),
                    self::edoSection(),
                    self::bankDetailsSection(),
                    self::userSection(),
                ])
                    ->skippable()
                    ->columnSpanFull(),
            ]);
    }

    private static function edoSection()
    {
        return Step::make('Электронный документооборот')
            ->icon('heroicon-o-cog')
            ->description('Наполните таблицу полями')
            ->schema([
                Section::make('Электронный документооборот')
                    ->schema([
                        TextInput::make('edo_operator')
                            ->label('Оператор ЭДО')
                            ->required(),
                        TextInput::make('edo_identifier')
                            ->label('Идентификатор ЭДО')
                            ->required(),
                    ])
                    ->columnSpanFull()
            ]);
    }

    private static function bankDetailsSection()
    {
        return Step::make('Банковские реквизиты')
            ->icon('heroicon-o-credit-card')
            ->description('Платёжные реквизиты организации')
            ->schema([
                Section::make('Банковские реквизиты')
                    ->description('Основные банковские реквизиты для проведения платежей')
                    ->schema([
                        Fieldset::make('Основные реквизиты')
                            ->schema([
                                TextInput::make('bankAccount.bank_name')
                                    ->label('Наименование банка')
                                    ->required()
                                    ->placeholder('ПАО Сбербанк')
                                    ->helperText('Полное официальное название банка')
                                    ->maxLength(255),

                                TextInput::make('bankAccount.bik')
                                    ->label('БИК банка')
                                    ->required()
                                    ->length(9)
                                    ->mask('999999999')
                                    ->placeholder('044525225')
                                    ->helperText('9-значный банковский идентификационный код'),
                            ])
                            ->columns(2),

                        Fieldset::make('Номера счетов')
                            ->schema([
                                TextInput::make('bankAccount.payment_account')
                                    ->label('Расчётный счёт')
                                    ->required()
                                    ->length(20)
                                    ->mask('99999999999999999999')
                                    ->placeholder('40702810100000000001')
                                    ->helperText('20-значный номер расчётного счёта'),

                                TextInput::make('bankAccount.correspondent_account')
                                    ->label('Корреспондентский счёт')
                                    ->required()
                                    ->length(20)
                                    ->mask('99999999999999999999')
                                    ->placeholder('30101810400000000225')
                                    ->helperText('20-значный корсчёт в Банке России'),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull()
            ]);
    }

    private static function organizationSection()
    {
        return Step::make('Реквизиты организации')
            ->icon('heroicon-o-building-office')
            ->description('Основные юридические реквизиты компании')
            ->schema([
                Section::make('Реквизиты организации')
                    ->description('Заполните основные данные организации')
                    ->schema([
                        // Основная информация
                        Fieldset::make('Основная информация')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Полное наименование')
                                    ->required()
                                    ->placeholder('Общество с ограниченной ответственностью "Ромашка"')
                                    ->helperText('Полное наименование согласно учредительным документам')
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('short_name')
                                    ->label('Краткое наименование')
                                    ->required()
                                    ->placeholder('ООО "Ромашка"')
                                    ->helperText('Сокращенное название для использования в системе')
                                    ->maxLength(100),
                            ])
                            ->columns(2),

                        // Регистрационные номера
                        Fieldset::make('Регистрационные данные')
                            ->schema([
                                TextInput::make('inn')
                                    ->label('ИНН')
                                    ->required()
                                    ->length(10)
                                    ->mask('9999999999')
                                    ->placeholder('7701234567')
                                    ->helperText('10 цифр для организаций')
                                    ->suffixIcon('heroicon-m-document-text'),

                                TextInput::make('kpp')
                                    ->label('КПП')
                                    ->required()
                                    ->length(9)
                                    ->mask('999999999')
                                    ->placeholder('770101001')
                                    ->helperText('Код причины постановки на учет')
                                    ->suffixIcon('heroicon-m-document-text'),

                                TextInput::make('ogrn')
                                    ->label('ОГРН')
                                    ->required()
                                    ->length(13)
                                    ->mask('9999999999999')
                                    ->placeholder('1027700092661')
                                    ->helperText('Основной государственный регистрационный номер')
                                    ->suffixIcon('heroicon-m-document-text'),
                            ])
                            ->columns(3),

                        // Адреса
                        Fieldset::make('Адреса организации')
                            ->schema([
                                Textarea::make('legal_address')
                                    ->label('Юридический адрес')
                                    ->required()
                                    ->rows(3)
                                    ->placeholder('123456, г. Москва, ул. Ленина, д. 1, оф. 100')
                                    ->helperText('Адрес согласно учредительным документам')
                                    ->columnSpan(1),

                                Textarea::make('postal_address')
                                    ->label('Почтовый адрес')
                                    ->rows(3)
                                    ->placeholder('123456, г. Москва, ул. Ленина, д. 1, оф. 100')
                                    ->helperText('Адрес для корреспонденции. Если совпадает с юридическим, оставьте пустым')
                                    ->columnSpan(1),
                            ])
                            ->columns(2),

                        // Руководство
                        Fieldset::make('Руководство')
                            ->schema([
                                TextInput::make('head_name')
                                    ->label('ФИО руководителя')
                                    ->required()
                                    ->placeholder('Иванов Иван Иванович')
                                    ->helperText('Полное имя руководителя организации')
                                    ->suffixIcon('heroicon-m-user'),

                                TextInput::make('head_position')
                                    ->label('Должность руководителя')
                                    ->required()
                                    ->placeholder('Генеральный директор')
                                    ->helperText('Официальная должность согласно документам')
                                    ->suffixIcon('heroicon-m-briefcase'),
                            ])
                            ->columns(2),
                    ])
                    ->columnSpanFull()
            ]);
    }

    private static function userSection()
    {
        return Step::make('Учётная запись')
            ->icon('heroicon-o-cog')
            ->description('Данные для авторизации на портале')
            ->schema([
                Section::make('Учётная запись пользователя')
                    ->schema([
                        Fieldset::make('Данные для авторизации')
                            ->schema([
                                TextInput::make('user.email')
                                    ->label('Email адрес')
                                    ->required()
                                    ->email()
                                    ->unique('users', 'email', ignoreRecord: true)
                                    ->maxLength(255)
                                    ->placeholder('example@company.ru')
                                    ->helperText('Будет использоваться для входа в систему')
                                    ->suffixIcon('heroicon-m-envelope'),

                                TextInput::make('user.password')
                                    ->label('Пароль')
                                    ->required()
                                    ->password()
                                    ->revealable()
                                    ->minLength(5)
                                    ->helperText('Мин. число символов 5')
                                    ->maxLength(255),
                            ]),
                        Fieldset::make('Контактные данные')
                            ->schema([
                                TextInput::make('first_name')
                                    ->placeholder('Иван')
                                    ->label('Имя'),
                                TextInput::make('last_name')
                                    ->placeholder('Иванов')
                                    ->label('Фамилия'),
                                TextInput::make('middle_name')
                                    ->placeholder('Иванович')
                                    ->label('Отчество'),
                                TextInput::make('phone')
                                    ->label('Телефон')
                                    ->tel()
                                    ->prefix('+7')
                                    ->mask('(999) 999-99-99')
                                    ->placeholder('(999) 123-45-67')
                                    ->maxLength(18)
                                    ->rules(['regex:/^\(\d{3}\)\s\d{3}-\d{2}-\d{2}$/'])
                            ]),
                    ])
                    ->columnSpanFull()
            ]);
    }
}
