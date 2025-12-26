<?php

namespace App\Filament\Resources\NavigationOrders;

use App\Filament\Resources\NavigationOrders\Pages\CreateNavigationOrder;
use App\Filament\Resources\NavigationOrders\Pages\EditNavigationOrder;
use App\Filament\Resources\NavigationOrders\Pages\ListNavigationOrders;
use App\Filament\Resources\NavigationOrders\Schemas\NavigationOrderForm;
use App\Filament\Resources\NavigationOrders\Tables\NavigationOrdersTable;
use App\Models\NavigationOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class NavigationOrderResource extends Resource
{
    protected static ?string $model = NavigationOrder::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|null|UnitEnum $navigationGroup = 'Редактор';
    protected static ?string $navigationLabel = 'Страницы';
    protected static ?string $modelLabel = 'Страницы';
    protected static ?string $pluralModelLabel = 'Страницы';

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
        return NavigationOrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NavigationOrdersTable::configure($table);
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
            'index' => ListNavigationOrders::route('/'),
        ];
    }
}
