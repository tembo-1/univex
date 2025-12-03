<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('name')->label('name'),
                TextColumn::make('sku')->label('sku'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->groups([
                Group::make('category.name')
                    ->label('По категориям')
                    ->collapsible(),

                Group::make('manufacturer.name')
                    ->label('По производителям')
                    ->collapsible(),

                Group::make('is_active')
                    ->label('По статусу')
                    ->collapsible(),

                Group::make('created_at')
                    ->label('По дате создания')
                    ->date()
                    ->collapsible(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
