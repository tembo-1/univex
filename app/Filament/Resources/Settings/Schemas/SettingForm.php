<?php

namespace App\Filament\Resources\Settings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Глобальное значение')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('key')
                            ->label('Ключ')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Примеры: site_phone, org_name, social_vk'),

                        TextInput::make('value')
                            ->label('Значение')
                            ->required(),

                        Textarea::make('description')
                            ->label('Описание')
                            ->rows(2)
                            ->required(),
                    ]),

            ]);
    }
}
