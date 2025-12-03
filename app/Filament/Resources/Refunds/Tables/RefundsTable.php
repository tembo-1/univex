<?php

namespace App\Filament\Resources\Refunds\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RefundsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('client_name')
                    ->label('Клиент')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('order.user.email')
                    ->label('Email клиента')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('refundStatus.name')
                    ->label('Статус претензии')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Открыта' => 'warning',
                        'Закрыта' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->label('Сумма возврата')
                    ->money('RUB')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('refund_items_count')
                    ->label('Товаров')
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('quantity')
                    ->label('Общее количество товаров')
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->description(fn ($record) => $record->created_at->diffForHumans())
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('updated_at')
                    ->label('Обновлен')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('refund_status_id')
                    ->label('Статус заказа')
                    ->relationship('refundStatus', 'name')
                    ->searchable()
                    ->preload()
                    ->placeholder('Все статусы'),

                Filter::make('created_at')
                    ->schema([
                        Select::make('period')
                            ->label('Период')
                            ->options([
                                'today' => 'Сегодня',
                                'yesterday' => 'Вчера',
                                'this_week' => 'Эта неделя',
                                'last_week' => 'Прошлая неделя',
                                'this_month' => 'Этот месяц',
                                'last_month' => 'Прошлый месяц',
                                'this_year' => 'Этот год',
                            ])
                            ->placeholder('Выберите период'),
                        DatePicker::make('created_from')
                            ->label('От даты'),
                        DatePicker::make('created_until')
                            ->label('До даты'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['period'] ?? null,
                                function (Builder $query, string $period) {
                                    match ($period) {
                                        'today' => $query->whereDate('created_at', today()),
                                        'yesterday' => $query->whereDate('created_at', today()->subDay()),
                                        'this_week' => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]),
                                        'last_week' => $query->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()]),
                                        'this_month' => $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]),
                                        'last_month' => $query->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]),
                                        'this_year' => $query->whereYear('created_at', now()->year),
                                    };
                                }
                            )
                            ->when(
                                $data['created_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
//                EditAction::make(),
            ])
            ->toolbarActions([
//                BulkActionGroup::make([
//                    DeleteBulkAction::make(),
//                ]),
            ]);
    }
}
