<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Notification;
use Illuminate\Support\Collection;
use Livewire\Component;

class BasketPage extends Component
{
    public ?Collection $cartItems;
    public Collection $notifications;
    public ?Cart $cart;

    public function mount()
    {
        $this->cart = Cart::query()
            ->with(['cartItems.warehouseProduct.productPrice.product'])
            ->firstWhere('user_id', auth()->id());

        if ($this->cart) {
            $this->cartItems = $this->cart->cartItems;
        } else {
            $this->cartItems = collect();
        }

       $this->notifications = Notification::query()
           ->where('notification_type_id', 2)
           ->get();
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

    public function add(string $sku, int $quantity)
    {
        dd($sku, $quantity);
    }

    public function render()
    {
        return view('livewire.basket-page');
    }
}
