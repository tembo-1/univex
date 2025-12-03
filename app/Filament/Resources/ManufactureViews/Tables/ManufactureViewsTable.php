<?php

namespace App\Filament\Resources\ManufactureViews\Tables;

use App\Models\ManufacturerView;
use App\Models\ProductView;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ManufactureViewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('manufacture.name')
                    ->label('Категория')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($state) =>
                        strlen($state) > 50 ? substr($state, 0, 50) . '...' : $state
                    )
                    ->limit(50),

                TextColumn::make('views_count')
                    ->label('Просмотры')
                    ->numeric()
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 0, '', ' '))
                    ->color('success')
                    ->weight('bold'),

                TextColumn::make('updated_at')
                    ->label('Последнее изменение')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->description(fn (ManufacturerView $record) => $record->updated_at->diffForHumans()),
            ])
            ->filters([
                //
            ])
            ->recordActions([
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
