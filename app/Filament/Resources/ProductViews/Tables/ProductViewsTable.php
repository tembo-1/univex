<?php

namespace App\Filament\Resources\ProductViews\Tables;

use App\Models\ProductView;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductViewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->label('Товар')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($state) =>
                        strlen($state) > 50 ? substr($state, 0, 50) . '...' : $state
                    )
                    ->limit(50),

                TextColumn::make('product.code')
                    ->label('Артикул')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Артикул скопирован'),

                TextColumn::make('product.manufacturer.name')
                    ->label('Производитель')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Не указан')
                    ->formatStateUsing(fn ($state) => $state ?? '—'),

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
                    ->description(fn (ProductView $record) => $record->updated_at->diffForHumans())
                    ->toggleable(isToggledHiddenByDefault: true),
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
