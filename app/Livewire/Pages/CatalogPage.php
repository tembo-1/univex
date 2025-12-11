<?php

namespace App\Livewire\Pages;

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

    public $pendingSelectedManufacturers = [];
    public $pendingInStock = false;
    public $pendingOnSale = false;
    public $pendingSearch = '';
    public $filtersChanged = false;

    public function mount()
    {
        $this->pendingSelectedManufacturers = $this->selectedManufacturers;
        $this->pendingInStock = $this->inStock;
        $this->pendingOnSale = $this->onSale;
        $this->pendingSearch = $this->search; // ДОБАВЛЕНО
    }

    public function getProductsProperty()
    {
        $query = Product::query()
            ->with('manufacturer')
            ->select(['id', 'name', 'manufacturer_id', 'sku', 'oem'])
            ->orderBy('id');

        // Применяем ПОИСК из активных фильтров
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', $this->search . '%')
                    ->orWhere('sku', 'like', $this->search . '%')
                    ->orWhere('id', 'like', $this->search . '%')
                    ->orWhereHas('manufacturer', function($mq) {
                        $mq->where('name', 'like', $this->search . '%');
                    });
            });
        }

        if (!empty($this->selectedManufacturers)) {
            $query->whereIn('manufacturer_id', $this->selectedManufacturers);
        }

        if ($this->inStock) {
            $query->where('product_warehouse_status_id', 1);
        }

        if ($this->onSale) {
            $query->where('on_sale', true);
        }

        return $query->paginate($this->perPage);
    }

    public function getManufacturersProperty()
    {
        $query = Manufacturer::query()
            ->select(['id', 'name'])
            ->orderBy('id');

        if ($this->manufacturerSearch) {
            $query->where('name', 'like', $this->manufacturerSearch . '%');
        }

        if (empty($this->manufacturerSearch) && !empty($this->pendingSelectedManufacturers)) {
            $selectedManufacturers = Manufacturer::whereIn('id', $this->pendingSelectedManufacturers)
                ->select(['id', 'name'])
                ->orderBy('name')
                ->get();

            $otherManufacturers = $query->whereNotIn('id', $this->pendingSelectedManufacturers)
                ->limit(10 - $selectedManufacturers->count())
                ->get();

            return $selectedManufacturers->merge($otherManufacturers);
        }

        return $query->limit(10)->get();
    }

    public function getPendingFilteredProductsCountProperty()
    {
        $query = Product::query()
            ->with('manufacturer')
            ->select(['id', 'name', 'manufacturer_id', 'sku', 'oem'])
            ->orderBy('id');

        if ($this->pendingSearch) {
            $query->where(function($q) {
                $q->where('name', 'like', $this->pendingSearch . '%')
                    ->orWhere('sku', 'like', $this->pendingSearch . '%')
                    ->orWhere('id', 'like', $this->pendingSearch . '%')
                    ->orWhereHas('manufacturer', function($mq) {
                        $mq->where('name', 'like', $this->pendingSearch . '%');
                    });
            });
        }

        if (!empty($this->pendingSelectedManufacturers)) {
            $query->whereIn('manufacturer_id', $this->pendingSelectedManufacturers);
        }

        if ($this->pendingInStock) {
            $query->where('product_warehouse_status_id', 1);
        }

        if ($this->pendingOnSale) {
            $query->where('on_sale', true);
        }

        return $query->count();
    }

    public function applyFilters()
    {
        // Применяем ВСЕ временные фильтры, включая поиск
        $this->search = $this->pendingSearch;
        $this->selectedManufacturers = $this->pendingSelectedManufacturers;
        $this->inStock = $this->pendingInStock;
        $this->onSale = $this->pendingOnSale;

        $this->filtersChanged = false;
        $this->resetPage();
        $this->showFilters = false;
    }

    public function clearFilters()
    {
        $this->reset([
            'search',
            'selectedManufacturers',
            'inStock',
            'onSale',
            'pendingSearch',
            'pendingSelectedManufacturers',
            'pendingInStock',
            'pendingOnSale',
            'manufacturerSearch'
        ]);
        $this->filtersChanged = false;
        $this->resetPage();
    }

    // Отслеживаем изменения временных фильтров
    public function updatedPendingSelectedManufacturers()
    {
        $this->filtersChanged = true;
    }

    public function updatedPendingInStock()
    {
        $this->filtersChanged = true;
    }

    public function updatedPendingOnSale()
    {
        $this->filtersChanged = true;
    }

    // ДОБАВЛЕНО: отслеживаем изменение временного поиска
    public function updatedPendingSearch()
    {
        $this->filtersChanged = true;
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
