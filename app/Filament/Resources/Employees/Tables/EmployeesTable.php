<?php

namespace App\Filament\Resources\Employees\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;

class EmployeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_roles')
                    ->label('Группа')
                    ->badge()
                    ->getStateUsing(function ($record) {
                        return $record->user->getRoleNames()->join(', ') ?: '—';
                    })
                    ->color('primary'),

                TextColumn::make('last_name')
                    ->label('ФИО')
                    ->sortable()
                    ->searchable()
                    ->weight('font-semibold')
                    ->color('gray-900')
                    ->description(fn ($record) => "{$record->first_name} {$record->middle_name}"),

                // Email
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-envelope')
                    ->color('blue-600')
                    ->copyable(),

                // Телефон
                TextColumn::make('internal_phone')
                    ->label('Телефон')
                    ->searchable()
                    ->icon('heroicon-o-phone')
                    ->color('green-600')
                    ->copyable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('created_at')
                    ->label('Добавлен')
                    ->date('d.m.Y')
                    ->sortable()
                    ->color('gray-500')
                    ->toggleable(isToggledHiddenByDefault: false),

                ToggleColumn::make('is_active')
                    ->label('Активен')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Роль')
                    ->options(Role::query()->pluck('name', 'id'))
                    ->query(function ($query, array $data) {

                        if (!empty($data['value'])) {
                            $query->whereHas('user.roles', function ($q) use ($data) {
                                $q->where('id', $data['value']);
                            });
                        }
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('delete')
                        ->label('Удалить выбранные')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Удаление аккаунтов')
                        ->modalDescription('Вы уверены, что хотите удалить выбранные аккаунты? Это действие нельзя отменить.')
                        ->modalSubmitActionLabel('Да, удалить')
                        ->modalCancelActionLabel('Отмена')
                        ->action(function ($records) {
                            /** @var $records Collection */
                            $records->map(function ($record) {
                                $record->user->delete();
                            });

                            // Отправляем уведомление
                            Notification::make()
                                ->title('Аккаунты удалены')
                                ->body('Выбранные аккаунты успешно удалены')
                                ->success()
                                ->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->deferLoading();
    }
}
