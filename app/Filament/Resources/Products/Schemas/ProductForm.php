<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use App\Models\Manufacturer;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Основная информация - левая колонка
                Section::make('📦 Основная информация')
                    ->description('Название, артикулы и классификация товара')
                    ->icon('heroicon-o-shopping-bag')
                    ->schema([
                        Fieldset::make('Название товара')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Полное название')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: 500)
                                    ->placeholder('Смартфон Apple iPhone 15 Pro 256GB')
                                    ->helperText('Название, которое увидят покупатели в каталоге')
                                    ->suffixIcon('heroicon-m-sparkles')
                                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                        if (empty($get('slug')) && !empty($state)) {
                                            $set('slug', Str::slug($state));
                                        }
                                    }),
                            ])
                            ->columns(1),

                        Fieldset::make('Артикулы (SKU, OEM)')
                            ->schema([
                                TextInput::make('sku')
                                    ->required()
                                    ->maxLength(100)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('IP15PRO256BLK')
                                    ->helperText('Уникальный идентификатор в системе')
                                    ->suffixIcon('heroicon-m-cog'),
                                TextInput::make('oem')
                                    ->maxLength(100)
                                    ->nullable()
                                    ->placeholder('A2848')
                                    ->helperText('Оригинальный код производителя')
                                    ->suffixIcon('heroicon-m-cog'),
                            ]),

                        Fieldset::make('Производитель')
                            ->schema([
                                Select::make('manufacturer_id')
                                    ->label('Производитель')
                                    ->searchable()
                                    ->preload()
                                    ->nullable()
                                    ->placeholder('Выберите бренд...')
                                    ->helperText('Бренд или производитель товара')
                                    ->suffixIcon('heroicon-m-building-storefront')
                                    ->options(Manufacturer::where('is_active', true)->pluck('name', 'id')),
                            ]),

                    ])
                    ->columnSpan(2)
                    ->extraAttributes(['class' => 'bg-gray-50/50 rounded-xl border border-gray-200']),

                // Правая колонка - URL, изображения и статус
                Section::make('🔗 Публикация и медиа')
                    ->description('URL-адрес, изображения и видимость товара')
                    ->icon('heroicon-o-globe-alt')
                    ->schema([
                        // ЧПУ с динамическим префиксом
                        Fieldset::make('URL-адрес товара')
                            ->schema([
                                TextInput::make('slug')
                                    ->label('ЧПУ-адрес')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('apple-iphone-15-pro')
                                    ->helperText(function (callable $get) {
                                        $categoryId = $get('category_id');
                                        $slug = $get('slug');
                                        if ($categoryId) {
                                            $category = Category::find($categoryId);
                                            return $category
                                                ? "📎 Будет доступен: /{$category->slug}/$slug"
                                                : '🌐 Глобальный URL товара';
                                        }
                                        return '🌐 Глобальный URL товара';
                                    })
                                    ->prefix(function (callable $get) {
                                        $categoryId = $get('category_id');
                                        if ($categoryId) {
                                            $category = Category::find($categoryId);
                                            return $category ? "/$category->slug/" : '/catalog/';
                                        }
                                        return '/catalog/';
                                    })
                                    ->suffixIcon('heroicon-m-link')
                                    ->suffixAction(
                                        Action::make('generateSlug')
                                            ->icon('heroicon-m-arrow-path')
                                            ->color('gray')
                                            ->size('sm')
                                            ->tooltip('Сгенерировать из названия')
                                            ->action(function (callable $get, callable $set) {
                                                $name = $get('name');
                                                if (!empty($name)) {
                                                    $set('slug', Str::slug($name));
                                                }
                                            })
                                    ),
                            ])
                            ->columns(1),

                        Fieldset::make('Галерея изображений')
                            ->schema([
                                FileUpload::make('images')
                                    ->label('Изображения товара')
                                    ->directory('products')
                                    ->disk('public')
                                    ->image()
                                    ->imageEditor()
                                    ->maxSize(2048)
                                    ->reorderable()
                                    ->appendFiles()
                                    ->maxFiles(1)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->downloadable()
                                    ->openable(),
                            ])
                            ->columns(1),

                        // Статус товара
                        Fieldset::make('Статус публикации')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Видимость товара')
                                    ->default(true)
                                    ->onColor('success')
                                    ->offColor('danger')
                                    ->inline(false)
                                    ->helperText('Показывать товар в каталоге покупателям')
                                    ->onIcon('heroicon-m-eye')
                                    ->offIcon('heroicon-m-eye-slash')
                                    ,
                            ])
                            ->columns(1),
                    ])
                    ->columnSpan(1)
                    ->extraAttributes(['class' => 'bg-gray-50/50 rounded-xl border border-gray-200']),

                // Описание товара - на всю ширину
                Section::make('📝 Детальное описание')
                    ->description('Полное описание товара, характеристики и преимущества')
                    ->icon('heroicon-o-document-text')
                    ->collapsible()
                    ->collapsed(fn ($operation) => $operation === 'create')
                    ->schema([
                        RichEditor::make('description')
                            ->label('Текст описания')
                            ->nullable()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('products/attachments')
                            ->toolbarButtons([
                                'attachFiles',
                                'h2',
                                'h3',
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'blockquote',
                                'bulletList',
                                'orderedList',
                                'link',
                                'codeBlock',
                                'undo',
                                'redo',
                                'table',
                            ])

                            ->maxLength(5000)
                            ->extraInputAttributes(['style' => 'min-height: 200px;']),
                    ])
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'bg-gray-50/50 rounded-xl border border-gray-200']),
            ])
            ->columns(3);
    }
}
