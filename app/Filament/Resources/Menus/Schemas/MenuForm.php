<?php

namespace App\Filament\Resources\Menus\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class MenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Основная информация')
                    ->schema([
                        TextInput::make('name')
                            ->label('Название меню')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, $set) {
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->label('Техническое имя')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Используется в коде, только латинские буквы и дефисы'),

                        Select::make('site_page_id')
                            ->label('Ссылка меню')
                            ->relationship('sitePage', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Если меню ведет на конкретную страницу'),

                        Grid::make(3)
                            ->schema([
                                TextInput::make('position')
                                    ->label('Позиция')
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Чем меньше число, тем выше в списке'),

                                Toggle::make('is_active')
                                    ->label('Активно')
                                    ->default(true)
                                    ->inline(false),

                                Toggle::make('on_footer')
                                    ->label('В футере')
                                    ->default(true)
                                    ->inline(false),
                            ]),
                    ]),

                Section::make('Пункты меню')
                    ->schema([
                        Repeater::make('Под пункты меню')
                            ->relationship('menuItems')
                            ->label('')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Название пункта')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('slug')
                                            ->label('URL пункта')
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Опционально, для кастомных ссылок'),
                                    ]),

                                Select::make('site_page_id')
                                    ->label('Страница')
                                    ->relationship('sitePage', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpanFull(),

                                Grid::make(2)
                                    ->schema([
//                                        TextInput::make('position')
//                                            ->label('Порядок')
//                                            ->numeric()
//                                            ->default(0),

//                                        Toggle::make('is_active')
//                                            ->label('Активно')
//                                            ->default(true),
                                    ]),
                            ])
                            ->defaultItems(0)
                            ->addActionLabel('Добавить пункт меню')
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string =>
                                $state['name'] ?? 'Новый пункт'
                            )
                            ->columnSpanFull(),
                    ]), // Только при редактировании
            ]);
    }
}
