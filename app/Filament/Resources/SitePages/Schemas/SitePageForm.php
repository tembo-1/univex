<?php

namespace App\Filament\Resources\SitePages\Schemas;

use App\Models\SiteElementType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SitePageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Редактирование страницы')
                    ->tabs([
                        Tabs\Tab::make('Основное')
                            ->icon('heroicon-o-document')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Название страницы')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('slug')
                                            ->label('URL страницы')
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Только латинские буквы и дефисы'),
                                    ]),

                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('url')
                                            ->label('Внешний URL')
                                            ->placeholder('https://...')
                                            ->helperText('Если отличается от slug'),
                                    ]),
                            ]),

                        Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title страницы')
                                    ->maxLength(255),

                                TextInput::make('meta_description')
                                    ->label('Meta Description')
                                    ->maxLength(500)
                                    ->helperText('До 160 символов оптимально'),

                                TextInput::make('meta_keywords')
                                    ->label('Meta Keywords')
                                    ->helperText('Через запятую'),
                            ]),

                        Tabs\Tab::make('Структура страницы')
                            ->icon('heroicon-o-squares-2x2')
                            ->schema([
                                Repeater::make('siteBlocks')
                                    ->relationship('siteBlocks')
                                    ->addable(false)
                                    ->collapsible()
                                    ->deletable(false)
                                    ->label('Блоки страницы')
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Название блока')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('Галерея, текст, преимущества'),
                                            ]),

                                        // Динамические элементы блока
                                        Repeater::make('Элементы')
                                            ->relationship('siteElements')
                                            ->addable(false)
                                            ->deletable(false)
                                            ->label('')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextInput::make('name')
                                                            ->label('Название элемента')
                                                            ->disabled()
                                                            ->required()
                                                            ->maxLength(255),

                                                        Select::make('site_element_type_id')
                                                            ->label('Тип элемента')
                                                            ->relationship('siteElementType', 'name')
                                                            ->required()
                                                            ->hidden()
                                                            ->helperText('Определяет какие поля показывать'),
                                                    ]),
                                                self::getElementFields(),
                                            ])
                                            ->defaultItems(0)
                                            ->columns(1)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->persistTabInQueryString()
                    ->columnSpanFull(),
            ]);
    }

    private static function getElementFields()
    {
        return Grid::make(1)
            ->schema(function ($get, $set) {
                $typeId = $get('site_element_type_id');

                if (!$typeId) {
                    return [];
                }

                $type = SiteElementType::query()->find($typeId);

                if (!$type) {
                    return [];
                }

                $fields = [];

                switch ($type->slug) {
                    case 'text':
                        $fields[] = MarkdownEditor::make('content')
                            ->label('Текст')
                            ->toolbarButtons([
                                'bold', 'italic', 'link', 'blockquote',
                                'bulletList', 'orderedList',
                            ])
                            ->dehydrateStateUsing(fn ($state) =>
                            is_array($state) ? ($state[0] ?? '') : (string) $state
                            )
                            ->columnSpanFull();
                        break;

                    case 'custom-text':
                        $fields[] = RichEditor::make('content')
                            ->label('Содержание')
                            ->required()
                            ->maxLength(5000)
                            ->extraInputAttributes(['style' => 'min-height: 200px;'])
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'h2', 'h3',
                                'blockquote', 'codeBlock',
                                'bulletList', 'orderedList',
                                'link', 'attachFiles',
                                'undo', 'redo',
                            ])
                            // Преобразуем массив в строку при сохранении
                            ->dehydrateStateUsing(fn ($state): string =>
                            is_array($state) ? ($state[0] ?? '') : (string) $state
                            )
                            // Обрабатываем загруженное состояние
                            ->afterStateHydrated(function (RichEditor $component, $state) {
                                // Если state это массив, берем первый элемент
                                if (is_array($state)) {
                                    $component->state($state[0] ?? '');
                                } else {
                                    $component->state((string) $state);
                                }
                            })
                            ->fileAttachmentsDisk('documents')
                            ->fileAttachmentsDirectory('site-element-images')
                            ->fileAttachmentsVisibility('public')
                            ->columnSpanFull();
                        break;

                    case 'slider':
                        $fields[] = Repeater::make('siteElementImages')
                            ->relationship('siteElementImages')
                            ->label('Изображения слайдера')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Изображение')
                                            ->image()
                                            ->disk('documents')
                                            ->directory('site-element-images/sliders')
                                            ->visibility('public')
                                            ->imageEditor()
                                            ->maxSize(5120)
                                            ->required()
                                            ->columnSpanFull(),

                                        TextInput::make('alt')
                                            ->label('Alt текст')
                                            ->maxLength(255),

                                        TextInput::make('href')
                                            ->label('ссылка при клике')
                                            ->maxLength(255),
                                    ]),
                            ])
                            ->defaultItems(0)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string =>
                                $state['alt'] ?? ($state['title'] ?? 'Новое изображение')
                            )
                            ->columnSpanFull();
                        break;

                    case 'image':
                        $fields[] = FileUpload::make('image')
                            ->label('Изображение')
                            ->image()
                            ->disk('documents')
                            ->directory('site-element-images')
                            ->visibility('public')
                            ->imageEditor()
                            ->maxSize(5120)
                            ->multiple(false)
                            ->required()
                            ->columnSpanFull();

                        $fields[] = TextInput::make('alt')
                            ->label('Alt текст')
                            ->required()
                            ->maxLength(255);
                        break;
                }

                return $fields;
            })
            ->columnSpanFull();
    }
}
