<?php

namespace App\Livewire;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MyWidget extends StatsOverviewWidget
{
    public static function isLazy(): bool
    {
        return true;
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Количество Ваших необработанных заказов',
                Order::query()
                    ->where('employee_id', auth()->id())
                    ->where('order_status_id', 1)
                    ->count(),
            ),
            Stat::make('Количество необработанных возвратов', 2),
        ];
    }
}
