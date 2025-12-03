<?php

namespace App\Filament\Resources\ManufactureViews\Pages;

use App\Filament\Resources\ManufactureViews\ManufactureViewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListManufactureViews extends ListRecords
{
    protected static string $resource = ManufactureViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
