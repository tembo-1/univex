<?php

namespace App\Livewire\Page;

use App\Models\Order;
use Illuminate\Support\Collection;
use Livewire\Component;

class OrderItemsPage extends Component
{
    public Order $order;
    public Collection $orderItems;

    public function mount(int $id)
    {
        $this->order = Order::query()->find($id);
        $this->orderItems = $this->order->orderItems;
    }

    public function render()
    {
        return view('livewire.page.order-items-page');
    }
}
