<?php

namespace App\Filament\Resources\Callbacks\Tables;

use App\Models\Callback;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CallbacksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('name')
                    ->label('ФИО')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Телефон скопирован')
                    ->copyMessageDuration(1500),

                TextColumn::make('callbackType.name')
                    ->label('Тип обратной связи')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color(fn ($state): string => match ($state) {
                        'phone' => 'warning',
                        'telegram' => 'info',
                        'whatsapp' => 'success',
                        default => 'gray',
                    })
                    ->icon(fn ($state): string => match ($state) {
                        'Телефон' => 'heroicon-o-phone',
                        'Telegram' => 'heroicon-o-paper-airplane',
                        'WhatsApp' => 'heroicon-o-chat-bubble-left-right',
                        'Viber' => 'heroicon-o-megaphone',
                        default => 'heroicon-o-question-mark-circle',
                    }),

                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('updated_at')
                    ->label('Последнее обновление')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('callback_type_id')
                    ->label('Тип обратной связи')
                    ->relationship('callbackType', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                Action::make('call')
                    ->label('Позвонить')
                    ->icon('heroicon-o-phone')
                    ->color('success')
                    ->visible(fn (Callback $record): bool => $record->callbackType->name === 'phone')
                    ->url(fn (Callback $record): string => 'tel:' . $record->phone)
                    ->openUrlInNewTab(false),

                Action::make('telegram')
                    ->label('Написать в Telegram')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('blue')
                    ->visible(fn (Callback $record): bool => $record->callbackType->name === 'telegram')
                    ->url(fn (Callback $record): string => 'https://t.me/' . preg_replace('/[^0-9]/', '', $record->phone))
                    ->openUrlInNewTab(true),

                Action::make('whatsapp')
                    ->label('Написать в WhatsApp')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->visible(fn (Callback $record): bool => $record->callbackType->name === 'whatsapp')
                    ->url(fn (Callback $record): string => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $record->phone))
                    ->openUrlInNewTab(true),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->deferLoading();
    }
}
