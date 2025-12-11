<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('slug')
                    ->label('URL')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->copyable()
                    ->copyMessage('📋 URL скопирован!')
                    ->copyMessageDuration(1500)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                TextColumn::make('published_at')
                    ->label('Дата публикации')
                    ->sortable(),

                ToggleColumn::make('is_published')
                    ->label('Опубликовано')
                    ->sortable(),

                ToggleColumn::make('is_visible')
                    ->label('Видно на главной')
                    ->sortable()
                    ->onColor('success')
                    ->offColor('gray'),

                TextColumn::make('position')
                    ->label('Позиция')
                    ->sortable()
                    ->alignCenter()
                    ->prefix('#')
                    ->color('gray'),

                TextColumn::make('created_at')
                    ->label('Создано')
                    ->date('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->date('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->reorderable('position')
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->deferLoading();
    }
}
