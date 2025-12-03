<?php

namespace App\Filament\Resources\WareHouses;

use App\Filament\Resources\WareHouses\Pages\CreateWareHouse;
use App\Filament\Resources\WareHouses\Pages\EditWareHouse;
use App\Filament\Resources\WareHouses\Pages\ListWareHouses;
use App\Filament\Resources\WareHouses\Schemas\WareHouseForm;
use App\Filament\Resources\WareHouses\Tables\WareHousesTable;
use App\Models\Warehouse;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WareHouseResource extends Resource
{
    protected static ?string $model = Warehouse::class;

    protected static ?string $navigationLabel = 'Склады';
    protected static ?string $modelLabel = 'Склад';
    protected static ?string $pluralModelLabel = 'Склады';
    protected static string|null|UnitEnum $navigationGroup = 'Интернет торговля';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function canAccess(): bool
    {
        return auth()->user()->hasRole('Администратор');
    }

    public static function form(Schema $schema): Schema
    {
        return WareHouseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WareHousesTable::configure($table);
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
            'index' => ListWareHouses::route('/'),
            'create' => CreateWareHouse::route('/create'),
            'edit' => EditWareHouse::route('/{record}/edit'),
        ];
    }
}
