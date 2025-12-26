<?php

namespace App\Filament\Resources\SearchViews;

use App\Filament\Resources\SearchViews\Pages\CreateSearchView;
use App\Filament\Resources\SearchViews\Pages\EditSearchView;
use App\Filament\Resources\SearchViews\Pages\ListSearchViews;
use App\Filament\Resources\SearchViews\Schemas\SearchViewForm;
use App\Filament\Resources\SearchViews\Tables\SearchViewsTable;
use App\Models\NavigationOrder;
use App\Models\SearchView;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class SearchViewResource extends Resource
{
    protected static ?string $model = SearchView::class;

    protected static string|null|UnitEnum $navigationGroup = 'Статистика';
    protected static ?string $navigationLabel = 'Статистика поисков';
    protected static ?string $modelLabel = 'Статистика поисков';
    protected static ?string $pluralModelLabel = 'Статистика поисков';
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
        return SearchViewForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SearchViewsTable::configure($table);
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
            'index' => ListSearchViews::route('/'),
        ];
    }
}
