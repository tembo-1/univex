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
                TextColumn::make('name')->label('Название')->searchable()->sortable(),
                TextColumn::make('sku')->label('Артикул')->searchable()->sortable(),
                TextColumn::make('oem')->label('OEM')->searchable()->toggleable(),
                TextColumn::make('manufacturer.name')->label('Производитель')->searchable()->sortable(),
                TextColumn::make('productWarehouseStatus.name')->label('Статус')->badge(),
                TextColumn::make('on_sale')->label('Акция')
                    ->formatStateUsing(fn ($state) => $state ? 'Да' : 'Нет')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'gray'),
                TextColumn::make('sale_discount')->label('Скидка')
                    ->formatStateUsing(fn ($state) => $state ? $state : '-')
                    ->alignCenter(),
                TextColumn::make('min_order_quantity')->label('Мин. заказ')->alignCenter(),
                TextColumn::make('created_at')->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label('Обновлен')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
