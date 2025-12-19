<?php

namespace App\Filament\Resources\Catalogs\Tables;

use App\Models\Catalog;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class CatalogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Название каталога')
                    ->searchable()
                    ->sortable()
                    ->description(fn(Catalog $record) =>
                    strlen($record->description) > 80
                        ? substr($record->description, 0, 80) . '...'
                        : $record->description
                    )
                    ->wrap()
                    ->limit(40)
                    ->tooltip(fn(Catalog $record) => $record->name)
                    ->weight('semibold')
                    ->icon('heroicon-o-folder')
                    ->iconColor('primary'),

//                TextColumn::make('slug')
//                    ->badge()
//                    ->label('URL')
//                    ->copyable()
//                    ->copyMessage('URL скопирован')
//                    ->color('gray')
//                    ->icon('heroicon-o-link')
//                    ->limit(20)
//                    ->tooltip('Нажмите чтобы скопировать URL'),

                ToggleColumn::make('is_active')
                    ->label('Статус')
                    ->sortable()
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-o-check-circle')
                    ->offIcon('heroicon-o-x-circle')
                    ->tooltip(fn($state) => $state ? 'Активен' : 'Неактивен')
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->color('gray')
                    ->description(fn(Catalog $record) => $record->created_at->diffForHumans()),

                TextColumn::make('updated_at')
                    ->label('Обновлен')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color('gray')
                    ->description(fn(Catalog $record) => $record->updated_at->diffForHumans()),
            ])
            ->striped()
            ->defaultSort('created_at', 'desc')
            ->searchable(['name', 'description'])
            ->selectable()
            ->poll('30s')
            ->deferLoading();
    }
}
