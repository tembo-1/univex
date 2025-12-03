<?php

namespace App\Filament\Resources\Callbacks\Schemas;

use Filament\Schemas\Schema;

class CallbackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }
}
