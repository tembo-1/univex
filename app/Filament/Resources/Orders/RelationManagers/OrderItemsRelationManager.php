<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use App\Models\Product;
use App\Models\Warehouse;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    protected static ?string $title = 'Позиции товара';
    protected static ?string $navigationLabel = 'Позиции товара';
    protected static ?string $modelLabel = 'Позиции товара';
    protected static ?string $pluralModelLabel = 'Позиции товара';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product_name')
                    ->label('ID товара'),
                TextColumn::make('product_sku')
                    ->label('Артикул'),
                TextColumn::make('product_name')
                    ->label('Наименование'),
                TextColumn::make('warehouse.name')
                    ->label('Склад'),
                TextColumn::make('unit_price')
                    ->label('Цена')
                    ->money('RUB'),
                TextColumn::make('quantity')
                    ->label('Кол-во')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => $state . ' шт.')
                    ->extraAttributes(['class' => 'cursor-pointer'])
                    ->action(
                        EditAction::make()
                    ),
                TextColumn::make('total_amount')
                    ->label('Стоимость')
                    ->money('RUB'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Добавить товар в заказ')
                    ->modalHeading('Добавить товар в заказ')
                    ->after(function () {
                        redirect(request()->header('Referer'));
                    }),
            ])
            ->recordActions([
                DeleteAction::make()
                    ->after(function () {
                        redirect(request()->header('Referer'));
                    }),
                EditAction::make()
                    ->after(function () {
                        redirect(request()->header('Referer'));
                    }),
            ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Выберите товар и склад')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('product_id')
                            ->label('Товар')
                            ->searchable()
                            ->required()
                            ->reactive()
                            ->getSearchResultsUsing(function (string $search) {
                                // Ищем только по нужным полям с лимитом
                                return Product::query()
                                    ->where('name', 'like', "%$search%")
                                    ->orWhere('sku', 'like', "%$search%")
                                    ->orWhere('oem', 'like', "%$search%")
                                    ->limit(50) // Ограничиваем количество результатов
                                    ->get()
                                    ->mapWithKeys(function (Product $product) {
                                        return [
                                            $product->id => $product->name . ' | ' . $product->sku . ' | ' . $product->oem
                                        ];
                                    });
                            })
                            ->getOptionLabelUsing(function ($value) {
                                $product = Product::query()->find($value);
                                return $product ? $product->name . ' | ' . $product->sku . ' | ' . $product->oem : null;
                            })
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (!$state) return;

                                $product = Product::query()
                                    ->find($state);

                                if ($product) {
                                    $set('product_name', $product->name);
                                    $set('product_sku', $product->sku);
                                    $set('product_oem', $product->oem);
                                    $set('unit_price', $product->productPrice()?->min('price') ?? 0);
                                    $set('quantity', $product->min_order_quantity ?: 1);
                                    $set('total_amount', ($product->productPrice()?->min('price') ?? 0) * ($product->min_order_quantity ?: 1));
                                }
                            }),

                        Select::make('warehouse_id')
                            ->label('Склад')
                            ->required()
                            ->options(Warehouse::all()->pluck('name', 'id'))
                            ->searchable(),
                    ]),
                Fieldset::make('Данные о товаре')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('product_name')
                            ->label('Название товара')
                            ->disabled()
                            ->dehydrated()
                            ->columnSpanFull(),

                        TextInput::make('product_sku')
                            ->label('Артикул')
                            ->disabled()
                            ->dehydrated(),

                        TextInput::make('product_oem')
                            ->label('OEM')
                            ->disabled()
                            ->dehydrated(),

                        TextInput::make('unit_price')
                            ->label('Цена за единицу')
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $quantity = $get('quantity') ?? 1;
                                $set('total_amount', $state * $quantity);
                            }),

                        TextInput::make('quantity')
                            ->label('Количество')
                            ->numeric()
                            ->minValue(1)
                            ->default(1)
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $unitPrice = $get('unit_price') ?? 0;
                                $set('total_amount', $unitPrice * $state);
                            }),

                        TextInput::make('total_amount')
                            ->label('Общая стоимость')
                            ->numeric()
                            ->minValue(0)
                            ->disabled()
                            ->dehydrated(),
                    ]),
            ]);
    }
}
