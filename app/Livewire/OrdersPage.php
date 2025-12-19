<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Collection;
use Livewire\Component;

class OrdersPage extends Component
{
    public Collection $orders;

    public function mount()
    {
        $this->orders = Order::query()
           ->with('orderItems')
            ->get();
    }

    public function render()
    {
        return view('livewire.orders-page');
    }
}
