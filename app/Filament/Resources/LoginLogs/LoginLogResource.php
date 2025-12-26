<?php

namespace App\Filament\Resources\LoginLogs;

use App\Filament\Resources\LoginLogs\Pages\CreateLoginLog;
use App\Filament\Resources\LoginLogs\Pages\EditLoginLog;
use App\Filament\Resources\LoginLogs\Pages\ListLoginLogs;
use App\Filament\Resources\LoginLogs\Schemas\LoginLogForm;
use App\Filament\Resources\LoginLogs\Tables\LoginLogsTable;
use App\Models\LoginLog;
use App\Models\NavigationOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class LoginLogResource extends Resource
{
    protected static ?string $model = LoginLog::class;
    protected static string|null|UnitEnum $navigationGroup = 'Статистика';
    protected static ?string $navigationLabel = 'Авторизации клиентов';
    protected static ?string $modelLabel = 'Авторизации клиентов';
    protected static ?string $pluralModelLabel = 'Авторизации клиентов';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('Администратор')
            || auth()->user()?->getPermissionsViaRoles()?->pluck('name')->contains(strtolower(Str::camel(strtolower(static::getSlug()))));
    }

    public static function getNavigationSort(): ?int
    {
        $order = NavigationOrder::query()->firstWhere('slug', static::getSlug());

        return $order->position ?? 0;
    }

    public static function form(Schema $schema): Schema
    {
        return LoginLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoginLogsTable::configure($table);
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
            'index' => ListLoginLogs::route('/'),
        ];
    }
}
