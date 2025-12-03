<?php

namespace App\Filament\Resources\WareHouses\Pages;

use App\Filament\Resources\WareHouses\WareHouseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWareHouse extends EditRecord
{
    protected static string $resource = WareHouseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
