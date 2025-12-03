<?php

namespace App\Filament\Resources\ManufactureViews;

use App\Filament\Resources\ManufactureViews\Pages\CreateManufactureView;
use App\Filament\Resources\ManufactureViews\Pages\EditManufactureView;
use App\Filament\Resources\ManufactureViews\Pages\ListManufactureViews;
use App\Filament\Resources\ManufactureViews\Schemas\ManufactureViewForm;
use App\Filament\Resources\ManufactureViews\Tables\ManufactureViewsTable;
use App\Models\ManufacturerView;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ManufactureViewResource extends Resource
{
    protected static ?string $model = ManufacturerView::class;
    protected static string|null|UnitEnum $navigationGroup = 'Статистика';
    protected static ?string $navigationLabel = 'Просмотры категорий';
    protected static ?string $modelLabel = 'Просмотры категорий';
    protected static ?string $pluralModelLabel = 'Просмотры категорий';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ManufactureViewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ManufactureViewsTable::configure($table);
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
            'index' => ListManufactureViews::route('/'),
        ];
    }
}
