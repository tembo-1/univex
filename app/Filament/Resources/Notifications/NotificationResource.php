<?php

namespace App\Filament\Resources\Notifications;

use App\Filament\Resources\Notifications\Pages\CreateNotification;
use App\Filament\Resources\Notifications\Pages\EditNotification;
use App\Filament\Resources\Notifications\Pages\ListNotifications;
use App\Filament\Resources\Notifications\Schemas\NotificationForm;
use App\Filament\Resources\Notifications\Tables\NotificationsTable;
use App\Models\NavigationOrder;
use App\Models\Notification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class NotificationResource extends Resource
{
    protected static ?string $model = Notification::class;
    protected static string|null|UnitEnum $navigationGroup = 'Рассылки';
    protected static ?string $navigationLabel = 'Уведомления на сайте';
    protected static ?string $modelLabel = 'Уведомление на сайте';
    protected static ?string $pluralModelLabel = 'Уведомления на сайте';


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Notification';

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

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::countActive();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }

    public static function form(Schema $schema): Schema
    {
        return NotificationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NotificationsTable::configure($table);
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
            'index' => ListNotifications::route('/'),
            'create' => CreateNotification::route('/create'),
            'edit' => EditNotification::route('/{record}/edit'),
        ];
    }
}
