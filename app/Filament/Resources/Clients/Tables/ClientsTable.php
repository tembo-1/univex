<?php

namespace App\Filament\Resources\Clients\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('ID')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->width(50),

                TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('short_name')
                    ->label('Краткое название')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('inn')
                    ->label('ИНН')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('ИНН скопирован')
                    ->alignCenter()
                    ->width(100),

                TextColumn::make('kpp')
                    ->label('КПП')
                    ->searchable()
                    ->alignCenter()
                    ->width(100),

                TextColumn::make('ogrn')
                    ->label('ОГРН')
                    ->searchable()
                    ->alignCenter()
                    ->width(120),

                TextColumn::make('head_name')
                    ->label('Руководитель')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                TextColumn::make('head_position')
                    ->label('Должность')
                    ->searchable()
                    ->toggleable()
                    ->limit(25),

                TextColumn::make('first_name')
                    ->label('Имя')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('last_name')
                    ->label('Фамилия')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('middle_name')
                    ->label('Отчество')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->alignCenter()
                    ->width(130)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Обновлен')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->alignCenter()
                    ->width(130)
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
//                ViewAction::make(),
//                EditAction::make(),
            ])
            ->deferLoading();
    }
}
