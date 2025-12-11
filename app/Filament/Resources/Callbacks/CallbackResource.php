<?php

namespace App\Filament\Resources\Callbacks;

use App\Filament\Resources\Callbacks\Pages\ListCallbacks;
use App\Filament\Resources\Callbacks\Schemas\CallbackForm;
use App\Filament\Resources\Callbacks\Tables\CallbacksTable;
use App\Models\Callback;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CallbackResource extends Resource
{
    protected static ?string $model = Callback::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|null|UnitEnum $navigationGroup = 'Обратная связь';
    protected static ?string $navigationLabel = 'Обратная связь';
    protected static ?string $modelLabel = 'Обратная связь';
    protected static ?string $pluralModelLabel = 'Обратная связь';

    public static function form(Schema $schema): Schema
    {
        return CallbackForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CallbacksTable::configure($table);
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
            'index' => ListCallbacks::route('/'),
        ];
    }
}
