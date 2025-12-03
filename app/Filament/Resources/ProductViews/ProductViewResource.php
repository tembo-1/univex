<?php

namespace App\Filament\Resources\ProductViews;

use App\Filament\Resources\ProductViews\Pages\CreateProductView;
use App\Filament\Resources\ProductViews\Pages\EditProductView;
use App\Filament\Resources\ProductViews\Pages\ListProductViews;
use App\Filament\Resources\ProductViews\Schemas\ProductViewForm;
use App\Filament\Resources\ProductViews\Tables\ProductViewsTable;
use App\Models\ProductView;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProductViewResource extends Resource
{
    protected static ?string $model = ProductView::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|null|UnitEnum $navigationGroup = 'Статистика';
    protected static ?string $navigationLabel = 'Просмотры товаров';
    protected static ?string $modelLabel = 'Просмотры товаров';
    protected static ?string $pluralModelLabel = 'Просмотры товаров';

    public static function form(Schema $schema): Schema
    {
        return ProductViewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductViewsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProductViews::route('/'),
        ];
    }
}
