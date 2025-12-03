<?php

namespace App\Filament\Resources\LoginLogs\Tables;

use App\Models\LoginLog;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Query\Builder;

class LoginLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.client.name')
                    ->searchable()
                    ->label('Организация'),

                TextColumn::make('ip_address')
                    ->label('IP адрес')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('IP адрес скопирован')
                    ->copyMessageDuration(1500),

                TextColumn::make('country')
                    ->label('Страна')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Не определена')
                    ->formatStateUsing(fn ($state) => $state ?? '—'),

                TextColumn::make('city')
                    ->label('Город')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Не определен')
                    ->formatStateUsing(fn ($state) => $state ?? '—'),

                TextColumn::make('created_at')
                    ->label('Дата входа')
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Локация')
                    ->getStateUsing(function (LoginLog $record) {
                        if ($record->country && $record->city) {
                            return "{$record->city}, {$record->country}";
                        }
                        if ($record->country) {
                            return $record->country;
                        }
                        return 'Не определена';
                    })
                    ->badge()
                    ->color(fn ($state) => $state === 'Не определена' ? 'gray' : 'info'),

                TextColumn::make('user.email')
                    ->label('Email пользователя')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->label('Пользователь')
                    ->relationship('user.client', 'name')
                    ->searchable()
                    ->preload(),
                Filter::make('has_location')
                    ->label('С определенной локацией')
                    ->query(fn (Builder $query): Builder => $query->whereNotNull('country')),
                Filter::make('no_location')
                    ->label('Без локации')
                    ->query(fn (Builder $query): Builder => $query->whereNull('country')),
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
