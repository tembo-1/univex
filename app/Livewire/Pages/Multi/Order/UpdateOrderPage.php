<?php

namespace App\Livewire\Pages\Multi\Order;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;

class UpdateOrderPage extends Component
{
    public $order;
    public $orderItems;

    public function mount(int $id)
    {
        $this->order = Order::query()->find($id);
        $this->orderItems = $this->order->orderItems;

        $this->addBreadcrumbs();

        if ($this->order->order_status_id != 1) {
            return $this->redirect('orders');
        }
    }

    public function render()
    {
        return view('livewire.pages.multi.order.update-order-page');
    }

    public function remove(int $id)
    {
        if ($this->orderItems->count() === 1) {
            $this->dispatch('showToast',
                type: 'error',
                message: 'Нельзя оставлять заказ пустым'
            );

            return;
        }

        OrderItem::query()
            ->find($id)
            ->delete();

        $this->orderItems = $this->order->orderItems;
    }

    public function increment(int $id)
    {
        $orderItem = OrderItem::query()
            ->find($id);

        $orderItem->increment('quantity');

        $orderItem->update([
            'total_amount' => $orderItem->unit_price * $orderItem->quantity,
        ]);

        $this->order->refresh();
        $this->orderItems = $this->order->orderItems;
    }

    public function decrement(int $id)
    {
        $orderItem = OrderItem::query()
            ->find($id);

        if ($orderItem->quantity <= 1) {
            // Можно показать сообщение пользователю
            $this->dispatch('showToast',
                type: 'warning',
                message: 'Минимальное количество товара: 1'
            );
            return; // Прерываем выполнение
        }

        $orderItem->decrement('quantity');

        $orderItem->update([
            'total_amount' => $orderItem->unit_price * $orderItem->quantity,
        ]);

        $this->order->refresh();
        $this->orderItems = $this->order->orderItems;
    }

    public function updateQuantityInput(int $id, int $newQuantity)
    {
        $orderItem = OrderItem::find($id);

        if ($newQuantity < 1) {
            $this->dispatch('showToast',
                type: 'warning',
                message: 'Минимальное количество: 1'
            );
            $newQuantity = 1; // Устанавливаем минимум
        }

        $orderItem->update([
            'quantity' => $newQuantity,
            'total_amount' => $orderItem->unit_price * $newQuantity,
        ]);

        $this->orderItems = $this->order->fresh()->orderItems;
    }

    public function addBreadcrumbs(): void
    {
        $this->dispatch('updateBreadcrumbs',
            items: [
                [
                    'label' => 'История заказов',
                    'url'   => route('orders'),
                    'active' => false
                ],
                [
                    'label' => 'Заказ # ' . $this->order->id,
                    'active' => true
                ],
            ]
        );
    }
}
