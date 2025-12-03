<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;
    protected static ?string $modelLabel = 'Позицию товара123';

    public function getTitle(): string|Htmlable
    {
        return $this->record->name;
    }

    public function getHeading(): string
    {
        $name = request()->input('data.name') ?? $this->record->name;

        if (!empty($name)) {
            return "Редактирование: {$name}";
        }

        return 'Редактирование товара';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
