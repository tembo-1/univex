<?php

namespace App\Filament\Resources\Refunds\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RefundItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'refundItems';
    protected static ?string $title = 'Товары на возврат';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('refundItems')
            ->columns([
                TextColumn::make('orderItem.product.id')
                    ->label('ID товара'),
                TextColumn::make('refundType.name')
                    ->label('Причина возврата'),
                TextColumn::make('orderItem.product_name')
                    ->label('Наименование'),
                TextColumn::make('orderItem.product_sku')
                    ->label('Артикул'),
                TextColumn::make('orderItem.product_oem')
                    ->label('Артикул производителя'),
                TextColumn::make('orderItem.unit_price')
                    ->label('Цена за единицу')
                    ->money('RUB'),
                TextColumn::make('quantity')
                    ->label('Количество'),
                TextColumn::make('total_amount')
                    ->label('Общая стоимость')
                    ->money('RUB'),
            ])
            ->filters([
                //
            ])
            ->headerActions([

            ])
            ->recordActions([
            ])
            ->toolbarActions([
//                BulkActionGroup::make([
//                    DeleteBulkAction::make(),
//                ]),
            ]);
    }
}
