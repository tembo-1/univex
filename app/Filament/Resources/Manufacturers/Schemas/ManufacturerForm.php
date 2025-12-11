<?php

namespace App\Filament\Resources\Manufacturers\Schemas;

use App\Models\Category;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ManufacturerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Основные данные')
                    ->description('Название и структура категории')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Название категории')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(debounce: 400)
                                    ->placeholder('Например: Смартфоны и гаджеты')
                                    ->helperText('Уникальное название, которое будут видеть пользователи')
                                    ->suffixIcon('heroicon-m-shopping-bag')
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        if (empty($get('slug')) && !empty($state)) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),

                                TextInput::make('slug')
                                    ->label('ЧПУ-адрес')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('smartphones')
                                    ->helperText('URL-адрес категории. Генерируется автоматически')
                                    ->prefix('/catalog/')
                                    ->suffixIcon('heroicon-m-link')
                                    ->suffixAction(
                                        Action::make('generateSlug')
                                            ->icon('heroicon-m-arrow-path')
                                            ->tooltip('Обновить из названия')
                                            ->action(function (callable $get, callable $set) {
                                                $name = $get('name');
                                                if (!empty($name)) {
                                                    $set('slug', Str::slug($name));
                                                }
                                            })
                                    ),
                                TextInput::make('position')
                                    ->label('Порядок отображения')
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->helperText('0 - выше, 100 - ниже')
                                    ->suffixIcon('heroicon-m-bars-3')
                                    ->columnSpan(1),
                            ]),

                        Grid::make(2)
                            ->schema([
                                // Статус категории
                                Fieldset::make()
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Категория активна')
                                            ->default(true)
                                            ->onColor('success')
                                            ->offColor('danger')
                                            ->inline(false)
                                            ->helperText('Отображается ли категория на сайте')
                                            ->onIcon('heroicon-m-eye')
                                            ->offIcon('heroicon-m-eye-slash'),
                                    ])
                                    ->columns(1),
                            ]),
                    ])
                    ->columnSpan(2), // Занимает 2/3 ширины

                Section::make('Визуал и статус')
                    ->description('Изображение и активность категории')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        FileUpload::make('image')
                            ->label('Изображение категории')
                            ->disk('documents')
                            ->directory('categories')
                            ->visibility('public')
                            ->image()
                            ->imageEditor()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('400')
                            ->imageResizeTargetHeight('400')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->downloadable()
                            ->openable()
                            ->previewable(true)
                            ->panelAspectRatio('1:1') // Квадратный превью
                            ->panelLayout('integrated')
                            ->removeUploadedFileButtonPosition('center')
                            ->uploadButtonPosition('center')
                            ->uploadProgressIndicatorPosition('center'),


                    ])
                    ->columnSpan(1), // Занимает 1/3 ширины
            ])
            ->columns(3); // Общее количество колонок в форме
    }
}
