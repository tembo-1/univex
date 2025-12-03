<?php

namespace App\Filament\Resources\WareHouses\Pages;

use App\Filament\Resources\WareHouses\WareHouseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWareHouses extends ListRecords
{
    protected static string $resource = WareHouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
