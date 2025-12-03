<?php

namespace App\Filament\Resources\Manufacturers\RelationManagers;

use App\Filament\Resources\Products\ProductResource;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $title = 'Товары в категории';

    protected static string|null|BackedEnum $icon = 'heroicon-o-shopping-bag';

    protected static ?string $relatedResource = ProductResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([

            ]);
    }
}
