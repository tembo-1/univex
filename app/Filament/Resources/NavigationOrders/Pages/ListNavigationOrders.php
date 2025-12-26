<?php

namespace App\Filament\Resources\NavigationOrders\Pages;

use App\Filament\Resources\NavigationOrders\NavigationOrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNavigationOrders extends ListRecords
{
    protected static string $resource = NavigationOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
