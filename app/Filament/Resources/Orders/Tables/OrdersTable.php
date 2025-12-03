<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Filament\Actions\BulkAction;
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

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('user.client.short_name')
                    ->label('Клиент')
                    ->searchable()
                    ->sortable()
                    ->openUrlInNewTab(),

                TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->description(fn (Order $record) => $record->created_at->diffForHumans())
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('user.email')
                    ->label('Email клиента')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('orderStatus.name')
                    ->label('Статус')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Новый' => 'success',
                        'В обработке' => 'warning',
                        'Подтвержден' => 'info',
                        'Выполнен' => 'success',
                        'Отменен' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('shippingType.name')
                    ->label('Тип доставки')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('employee.full_name')
                    ->label('Менеджер')
                    ->placeholder('Не назначен')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('shipping_address')
                    ->label('Адрес доставки')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($state) => strlen($state) > 50 ? $state : null)
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('comment')
                    ->label('Комментарий')
                    ->searchable()
                    ->limit(30)
                    ->tooltip(fn ($state) => $state ? (strlen($state) > 30 ? $state : null) : null)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('order_items_count')
                    ->label('Товаров')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('quantity')
                    ->label('Общее количество')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('total_amount')
                    ->label('Сумма')
                    ->money('RUB')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->searchable([
                TextInput::make('asd')
                    ->label(123)
            ])
            ->filters([
                Filter::make('sku')
                    ->label('Поиск по артикулу')
                    ->schema([
                        TextInput::make('sku')
                            ->label('Поиск по артикулу')
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (empty($data['sku'])) {
                            return $query;
                        }

                        return $query->whereHas('orderItems', function ($q) use ($data) {
                            $q->where('product_sku', 'LIKE', "%{$data['sku']}%");
                        });
                    }),
                SelectFilter::make('employee_id')
                    ->label('Менеджер')
                    ->options(
                        \App\Models\User::query()
                            ->limit(50)
                            ->get()
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->default(auth()->id())
                    ->placeholder('Все менеджеры'),

                SelectFilter::make('order_status_id')
                    ->label('Статус заказа')
                    ->relationship('orderStatus', 'name')
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

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
