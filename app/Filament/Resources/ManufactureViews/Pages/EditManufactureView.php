<?php

namespace App\Filament\Resources\ManufactureViews\Pages;

use App\Filament\Resources\ManufactureViews\ManufactureViewResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditManufactureView extends EditRecord
{
    protected static string $resource = ManufactureViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
