<?php

namespace App\Filament\Resources\NavigationOrders\Pages;

use App\Filament\Resources\NavigationOrders\NavigationOrderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNavigationOrder extends EditRecord
{
    protected static string $resource = NavigationOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
