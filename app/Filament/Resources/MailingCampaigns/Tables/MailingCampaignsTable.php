<?php

namespace App\Filament\Resources\MailingCampaigns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MailingCampaignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('mailingStatus.name')
                    ->label('Статус')
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'Черновик' => 'gray',
                        'Запланирована' => 'warning',
                        'Отправляется' => 'info',
                        'Завершена' => 'success',
                        'Отменена' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('subject')
                    ->label('Тема')
                    ->searchable()
                    ->limit(50),

                TextColumn::make('scheduled_at')
                    ->label('Запланировано на')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),

                TextColumn::make('sent_at')
                    ->label('Отправлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),

                TextColumn::make('recipients_count')
                    ->label('Количество получателей')
                    ->badge()
                    ->color(fn($state) => str_contains($state, 'Всем') ? 'success' : 'gray'),
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
