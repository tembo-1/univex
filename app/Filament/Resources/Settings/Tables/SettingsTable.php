<?php

namespace App\Filament\Resources\Settings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Ключ')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->formatStateUsing(fn ($state) => Str::upper($state)),

                TextColumn::make('value')
                    ->label('Значение')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function ($record) {
                        return $record->value;
                    }),

                TextColumn::make('description')
                    ->label('Описание')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(function ($record) {
                        return $record->description;
                    }),

                TextColumn::make('updated_at')
                    ->label('Обновлено')
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
            ->groups([
                Group::make('key')
                    ->label('Группа')
                    ->getTitleFromRecordUsing(function ($record) {
                        $parts = explode('_', $record->key);
                        $prefix = $parts[0] ?? 'other';

                        $names = [
                            'org' => 'Организация',
                            'site' => 'Сайт',
                            'contact' => 'Контакты',
                            'social' => 'Соцсети',
                        ];

                        return $names[$prefix] ?? '📝 Общие';
                    })
                    ->collapsible(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->groupingSettingsHidden();
    }
}
