<?php

namespace App\Filament\Resources\ManufactureViews;

use App\Filament\Resources\ManufactureViews\Pages\CreateManufactureView;
use App\Filament\Resources\ManufactureViews\Pages\EditManufactureView;
use App\Filament\Resources\ManufactureViews\Pages\ListManufactureViews;
use App\Filament\Resources\ManufactureViews\Schemas\ManufactureViewForm;
use App\Filament\Resources\ManufactureViews\Tables\ManufactureViewsTable;
use App\Models\ManufacturerView;
use App\Models\NavigationOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class ManufactureViewResource extends Resource
{
    protected static ?string $model = ManufacturerView::class;
    protected static string|null|UnitEnum $navigationGroup = 'Статистика';
    protected static ?string $navigationLabel = 'Просмотры категорий';
    protected static ?string $modelLabel = 'Просмотры категорий';
    protected static ?string $pluralModelLabel = 'Просмотры категорий';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationSort(): ?int
    {
        $order = NavigationOrder::query()->firstWhere('slug', static::getSlug());

        return $order->position ?? 0;
    }
    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('Администратор')
            || auth()->user()?->getPermissionsViaRoles()?->pluck('name')->contains(strtolower(Str::camel(strtolower(static::getSlug()))));
    }


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
