<?php

namespace App\Livewire;

use App\Models\Manufacturer;
use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogPage extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';

    #[Url]
    public $selectedManufacturers = [];

    #[Url]
    public $inStock = false;

    #[Url]
    public $onSale = false;

    public $showFilters = false;
    public $manufacturerSearch = '';
    public $perPage = 20;

    public function getProductsProperty()
    {
        $query = Product::query()
            ->with('manufacturer');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('article', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search . '%')
                    ->orWhereHas('manufacturer', function($mq) {
                        $mq->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if (!empty($this->selectedManufacturers)) {
            $query->whereIn('manufacturer_id', $this->selectedManufacturers);
        }

        if ($this->inStock) {
            $query->where('quantity', '>', 0);
        }

        if ($this->onSale) {
            $query->where('is_on_sale', true);
        }

        return $query->orderBy('id')->paginate($this->perPage);
    }

    public function getManufacturersProperty()
    {
        $query = Manufacturer::query()
            ->orderBy('name');

        if ($this->manufacturerSearch) {
            $query->where('name', 'like', '%' . $this->manufacturerSearch . '%');
        }

        return $query->limit(20)->get();
    }

    public function getFilteredProductsCountProperty()
    {
        $query = Product::query();

        if ($this->search || !empty($this->selectedManufacturers) || $this->inStock || $this->onSale) {
            if ($this->search) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('article', 'like', '%' . $this->search . '%')
                        ->orWhere('id', 'like', '%' . $this->search . '%')
                        ->orWhereHas('manufacturer', function($mq) {
                            $mq->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            }

            if (!empty($this->selectedManufacturers)) {
                $query->whereIn('manufacturer_id', $this->selectedManufacturers);
            }

            if ($this->inStock) {
                $query->where('quantity', '>', 0);
            }

            if ($this->onSale) {
                $query->where('is_on_sale', true);
            }
        }

        return $query->count();
    }

    public function clearFilters()
    {
        $this->reset(['selectedManufacturers', 'inStock', 'onSale', 'search', 'manufacturerSearch']);
        $this->resetPage();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function render()
    {
        return view('livewire.catalog-page');
    }
}
