<?php

namespace App\Livewire\Pages\Multi\Order;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\WarehouseProduct;
use Livewire\Component;

class UpdateOrderPage extends Component
{
    public $order;
    public $orderItems;

    public $skuInput;
    public $qtyInput = 1;
    public $comment = '';

    public function mount(int $id)
    {
        $this->order = Order::query()->find($id);
        $this->orderItems = $this->order->orderItems;
        $this->comment = $this->order->comment;

        $this->addBreadcrumbs();

        if ($this->order->order_status_id != 1) {
            return $this->redirect('orders');
        }
    }

    public function submit()
    {
        $this->order->update([
            'comment' => $this->comment,
        ]);

        return $this->redirect(route('orders'));
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

    public function add()
    {
        $product = Product::query()
            ->where('sku', 'like', '%'.$this->skuInput.'%')
            ->first();

        if (!$product) {
            $this->dispatch('showToast',
                type: 'warning',
                message: 'Нет данного товара в каталоге!'
            );
            return;
        }

        $warehouseProduct = WarehouseProduct::query()
            ->where('product_id', $product->id)
            ->where('quantity', '>', 0)
            ->first();

        if (!$warehouseProduct) {
            $this->dispatch('showToast',
                type: 'warning',
                message: 'Нет данного товара на складе!'
            );
            return;
        }

        if ($warehouseProduct->quantity < $this->qtyInput) {
            $this->dispatch('showToast',
                type: 'warning',
                message: 'На складе нет нужного количества. Доступно: ' . $warehouseProduct->quantity
            );
            return;
        }

        $existingCartItem = $this->order->orderItems()
            ->where('product_id', $product->id)
            ->first();

        if ($existingCartItem) {
            $newQuantity = $existingCartItem->quantity + $this->qtyInput;

            if ($newQuantity > $warehouseProduct->quantity) {
                $this->dispatch('showToast',
                    type: 'warning',
                    message: 'Превышено доступное количество. Доступно: ' . $warehouseProduct->quantity
                );
                return;
            }

            $existingCartItem->update([
                'quantity' => $newQuantity
            ]);
        } else {
            $productPrice = $product->productPrices()->first();

            if (!$productPrice) {
                $this->dispatch('showToast',
                    type: 'warning',
                    message: 'Нет цены'
                );
                return;
            }

            $this->order->orderItems()->create([
                'product_id' => $product->id,
                'warehouse_id' => $warehouseProduct->warehouse_id,
                'product_name' => $product->name,
                'product_sku' => $product->sku,
                'unit_price' => $productPrice->price,
                'total_amount' => $productPrice->price * $this->qtyInput,
                'quantity' => $this->qtyInput,
            ]);
        }

        $this->skuInput = '';
        $this->qtyInput = 1;

        $this->orderItems = $this->order->orderItems;

        $this->dispatch('showToast',
            type: 'success', // Изменил на success
            message: 'Товар успешно добавлен в заказ'
        );
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
                    'url'   => route('orders.show', $this->order->id),
                    'active' => false
                ],
                [
                    'label' => 'Изменение заказа # ' . $this->order->id,
                    'active' => true
                ],
            ]
        );
    }
}
