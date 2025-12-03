<?php

namespace App\Filament\Resources\Callbacks\Pages;

use App\Filament\Resources\Callbacks\CallbackResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCallback extends CreateRecord
{
    protected static string $resource = CallbackResource::class;
}
