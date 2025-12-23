<?php

namespace App\Livewire\Pages\Multi\Order;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersPage extends Component
{
    use WithPagination;

    public int $perPage = 10;
    public Collection $statuses;

    #[Url]
    public string $search = '';
    public $status;
    public $period;

    public function mount()
    {
        $this->statuses = OrderStatus::all();

        $this->addBreadcrumbs();
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function loadOrder()
    {
        $query = Order::query()
            ->with('orderItems');

        $date = now();

        if ($this->search) {
            $searchTerm = $this->search . '%';

            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('orderItems', function($iq) use ($searchTerm) {
                    $iq->whereHas('product', function($pq) use ($searchTerm) {
                        $pq->where('id', 'LIKE', $searchTerm)
                            ->orWhere('sku', 'LIKE', $searchTerm)
                            ->orWhere('name', 'LIKE', $searchTerm);
                    })
                        ->orWhereHas('product.manufacturer', function($mq) use ($searchTerm) {
                            $mq->where('name', 'LIKE', $searchTerm);
                        });
                });
            });
        }

        if ($this->status) {
            $query->where('order_status_id', $this->status);
        }

        if ($this->period) {
            switch ($this->period) {
                case '1': $date = $date->subDay(); break;
                case '2': $date = $date->subWeek(); break;
                case '3': $date = $date->subMonth(); break;
                case '4': $date = $date->subMonths(3); break;
                case '5': $date = $date->subMonths(6); break;
            }
            $query->where('created_at', '>=', $date);
        }

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.pages.multi.order.orders-page', [
            'orders' => $this->loadOrder()
        ]);
    }

    public function addBreadcrumbs(): void
    {
        $this->dispatch('updateBreadcrumbs',
            items: [
                [
                    'label' => 'История заказа',
                    'active' => true
                ],
            ]
        );
    }
}
