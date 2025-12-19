<?php

namespace App\Filament\Resources\SearchViews\Pages;

use App\Filament\Resources\SearchViews\SearchViewResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSearchView extends EditRecord
{
    protected static string $resource = SearchViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
