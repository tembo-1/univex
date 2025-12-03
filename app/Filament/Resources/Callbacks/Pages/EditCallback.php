<?php

namespace App\Filament\Resources\Callbacks\Pages;

use App\Filament\Resources\Callbacks\CallbackResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCallback extends EditRecord
{
    protected static string $resource = CallbackResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
