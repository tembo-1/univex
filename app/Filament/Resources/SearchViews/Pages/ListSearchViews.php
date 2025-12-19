<?php

namespace App\Filament\Resources\SearchViews\Pages;

use App\Filament\Resources\SearchViews\SearchViewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSearchViews extends ListRecords
{
    protected static string $resource = SearchViewResource::class;
}
