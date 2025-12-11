<?php

namespace App\Filament\Resources\SitePages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SitePagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Название страницы')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('url')
                    ->label('URL')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray')
                    ->placeholder('Не указан')
                    ->formatStateUsing(fn ($state) => $state ?: '—'),

                TextColumn::make('title')
                    ->label('Title страницы')
                    ->limit(50)
                    ->tooltip(function ($state) {
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    })
                    ->wrap()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('meta_description')
                    ->label('Meta-Description')
                    ->limit(50)
                    ->tooltip(function ($state) {
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    })
                    ->wrap()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('meta_keywords')
                    ->label('Meta-Keywords')
                    ->limit(50)
                    ->tooltip(function ($state) {
                        if (strlen($state) > 50) {
                            return $state;
                        }
                        return null;
                    })
                    ->wrap()
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Статус')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->trueColor('success')
                    ->falseIcon('heroicon-o-x-circle')
                    ->falseColor('danger')
                    ->sortable(),
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
            ]);
    }
}
