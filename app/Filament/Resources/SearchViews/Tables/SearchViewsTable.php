<?php

namespace App\Filament\Resources\SearchViews\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SearchViewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('query')
                    ->label('Поисковый запрос')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    }),

                TextColumn::make('page')
                    ->label('Страница поиска')
                    ->formatStateUsing(fn ($state) => $state ?: 'Главная')
                    ->badge()
                    ->color(fn ($state) => $state ? 'gray' : 'blue')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('count')
                    ->label('Количество')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->formatStateUsing(fn ($state) => number_format($state, 0, '', ' '))
                    ->description(fn ($record) => $record->count > 1000 ? '🔥 Популярный' : null),

                TextColumn::make('created_at')
                    ->label('Первый поиск')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Последний поиск')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->since()
                    ->tooltip(fn ($record) => $record->updated_at->format('d.m.Y H:i:s')),
            ]);
    }
}
