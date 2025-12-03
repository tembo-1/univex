<?php

namespace App\Filament\Resources\ProductViews\Pages;

use App\Filament\Resources\ProductViews\ProductViewResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductView extends CreateRecord
{
    protected static string $resource = ProductViewResource::class;
}
