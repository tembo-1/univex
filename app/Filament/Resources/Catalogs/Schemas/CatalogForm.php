<?php

namespace App\Filament\Resources\Catalogs\Schemas;

use Asmit\FilamentUpload\Forms\Components\AdvancedFileUpload;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CatalogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Информация о каталоге')
                    ->schema([
                        TextInput::make('name')
                            ->label('Название каталога')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $set) {
                                if (!empty($state)) {
                                    $set('slug', Str::slug($state));
                                }
                            })
                            ->placeholder('Введите название каталога')
                            ->helperText('Это название увидят пользователи')
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label('URL адрес')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('url-kataloga')
                            ->helperText('Используется в адресной строке')
                            ->prefix(fn() => url('/catalogs/'))
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Описание')
                            ->rows(3)
                            ->placeholder('Опишите, что содержится в каталоге...')
                            ->helperText('Необязательное поле, максимум 1000 символов')
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Каталог активен')
                            ->default(true)
                            ->inline(false)
                            ->helperText('Активные каталоги отображаются на сайте')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
                Section::make('Приложенные файлы')
                    ->schema([
                        Repeater::make('files')
                            ->relationship('catalogFiles')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Название каталога')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Введите файла каталога, который будет виден на сайте')
                                    ->helperText('Это название увидят пользователи')
                                    ->columnSpanFull(),

                                AdvancedFileUpload::make('file_path')
                                    ->label('Файл')
                                    ->required()
                                    ->disk('documents')
                                    ->directory('catalogs')
                                    ->visibility('public')
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'image/jpeg', 'image/png',
                                        'application/msword',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                        'application/vnd.ms-excel',
                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                    ])
                                    ->columnSpan(2),

                                Toggle::make('is_active')
                                    ->label('Активен')
                                    ->default(true)
                                    ->columnSpan(1),
                            ])
                    ])
            ]);
    }
}
