<?php

namespace App\Filament\Resources\ProductViews\Pages;

use App\Filament\Resources\ProductViews\ProductViewResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProductView extends EditRecord
{
    protected static string $resource = ProductViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
