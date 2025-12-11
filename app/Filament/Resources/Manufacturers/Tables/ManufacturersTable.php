<?php

namespace App\Filament\Resources\Manufacturers\Tables;

use App\Filament\Resources\Manufacturers\RelationManagers\ProductsRelationManager;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
//use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ManufacturersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Наименование категории')
                    ->searchable(),
                TextColumn::make('slug')
                    ->label('ЧПУ-адрес')
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->label('Категория активна')
                    ->default(true)
                    ->inline(false)
                    ->onIcon('heroicon-m-eye')
                    ->offIcon('heroicon-m-eye-slash'),
                TextColumn::make('products_count')
                    ->label('Количество товаров')
                    ->counts('products')
                    ->sortable()
                    ->alignCenter()
                    ->color('blue-600')
                    ->weight('font-medium')
                    ->formatStateUsing(fn ($state) => $state > 0 ? "️ {$state}" : '—'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->deferLoading();
    }
}
