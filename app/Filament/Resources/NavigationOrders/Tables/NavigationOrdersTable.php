<?php

namespace App\Filament\Resources\NavigationOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NavigationOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('position')
            ->defaultSort('position')
            ->columns([
                TextColumn::make('position')
                    ->sortable()
                    ->label('Поз.')
                    ->badge(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Название'),
            ]);
    }
}
