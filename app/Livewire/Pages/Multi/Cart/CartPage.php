<?php

namespace App\Livewire\Pages\Multi\Cart;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\DeliveryAddress;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\WarehouseProduct;
use Illuminate\Support\Collection;
use Livewire\Component;

class CartPage extends Component
{
    public ?Collection $cartItems;
    public Collection $notifications;
    public bool $hasMore;
    public ?Cart $cart = null;
    public Collection $deliveryAddresses;
    public string $skuInput = '';
    public int $qtyInput = 1;

    public string $address = ''; // Для адреса
    public string $comment = ''; // Для комментария
    public string $deliveryType = 'pickup'; // Для типа доставки: 'pickup' или 'delivery'

    public function mount()
    {
        $this->loadCartItems();

        $this->deliveryAddresses = DeliveryAddress::all();

        $this->notifications = Notification::query()
           ->where('notification_type_id', 2)
           ->get();
    }

    public function loadCartItems()
    {
        $this->cart = Cart::query()
            ->with(['cartItems.warehouseProduct.product'])
            ->firstWhere('user_id', auth()->id());

        if ($this->cart) {
            $this->cartItems = $this->cart->cartItems;
        } else {
            $this->cartItems = collect();
        }

        $this->hasMore();
    }

    public function increment(int $cartItemId)
    {
        $cartItem = CartItem::query()
            ->find($cartItemId);

        $cartItem->increment('quantity');
        $this->cartItems = $this->cart->cartItems;
    }

    public function decrement(int $cartItemId)
    {
        $cartItem = CartItem::query()
            ->find($cartItemId);

        $cartItem->decrement('quantity');

        $this->cartItems = $this->cart->cartItems;
    }

    public function remove(int $cartItemId)
    {
        CartItem::query()
            ->find($cartItemId)
            ->delete();

        $this->cartItems = $this->cart->cartItems;
    }

    public function hasMore()
    {
        if ($this->cart?->cartItems()->exists()) {
            $this->hasMore = true;
        } else {
            $this->hasMore = false;
        }
    }

    public function placeOrder()
    {
        if ($this->deliveryType == 'pickup') {
            if ($this->address != '') {
                $order = Order::query()
                    ->create([
                        'employee_id' => auth()->user()->client?->employee?->id,
                        'shipping_type_id' => 1,
                        'user_id' => auth()->id(),
                        'order_status_id' => 1,
                        'shipping_address' => $this->address,
                        'comment' => $this->comment,
                    ]);

                $this->cartItems->each(function (CartItem $cartItem) use ($order) {
                    OrderItem::query()
                        ->create([
                            'order_id' => $order->id,
                            'product_id' => $cartItem->warehouseProduct->product_id,
                            'warehouse_id' => $cartItem->warehouseProduct->warehouse_id,
                            'product_name' => $cartItem->warehouseProduct->product->name,
                            'product_sku' => $cartItem->warehouseProduct->product->sku,
                            'product_oem' => $cartItem->warehouseProduct->product->oem,
                            'unit_price' => $cartItem->price,
                            'total_amount' => $cartItem->price * $cartItem->quantity,
                            'quantity' => $cartItem->quantity,
                        ]);
                });
            } else {
                $this->dispatch('showToast',
                    type: 'warning',
                    message: 'Заполните поле доставки'
                );
            }
        } else {
            $order = Order::query()
                ->create([
                    'employee_id' => auth()->user()->client?->employee?->id,
                    'shipping_type_id' => 2,
                    'user_id' => auth()->id(),
                    'order_status_id' => 1,
                    'shipping_address' => $this->address,
                ]);

            $this->cartItems->each(function (CartItem $cartItem) use ($order) {
                OrderItem::query()
                    ->create([
                        'order_id' => $order->id,
                        'product_id' => $cartItem->warehouseProduct->product_id,
                        'warehouse_id' => $cartItem->warehouseProduct->warehouse_id,
                        'product_name' => $cartItem->warehouseProduct->product->name,
                        'product_sku' => $cartItem->warehouseProduct->product->sku,
                        'product_oem' => $cartItem->warehouseProduct->product->oem,
                        'unit_price' => $cartItem->price,
                        'total_amount' => $cartItem->price * $cartItem->quantity,
                        'quantity' => $cartItem->quantity,
                    ]);
            });
        }

        CartItem::query()
            ->whereIn('id', $this->cartItems->pluck('id'))
            ->delete();

        $this->loadCartItems();

        $this->address = '';
        $this->comment = '';
        $this->hasMore();

        $this->dispatch('showToast',
            type: 'success',
            message: 'Заказ успешно размещён'
        );
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

        if (!$this->cart) {
            $this->cart = Cart::create([
                'user_id' => auth()->id(),
            ]);
        }

        $existingCartItem = $this->cart->cartItems()
            ->where('warehouse_product_id', $warehouseProduct->id)
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
                    message: 'Невозможно определить цену товара'
                );
                return;
            }

            $this->cart->cartItems()->create([
                'warehouse_product_id' => $warehouseProduct->id,
                'price' => $productPrice->price,
                'quantity' => $this->qtyInput,
            ]);
        }

        $this->loadCartItems();

        $this->skuInput = '';
        $this->qtyInput = 1;

        $this->dispatch('showToast',
            type: 'success', // Изменил на success
            message: 'Товар успешно добавлен в корзину'
        );
    }

    public function render()
    {
        return view('livewire.pages.multi.cart.cart-page');
    }
}
