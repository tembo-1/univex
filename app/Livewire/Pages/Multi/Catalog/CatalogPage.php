<?php

namespace App\Livewire\Pages\Multi\Catalog;

use App\Models\Manufacturer;
use App\Models\ManufacturerView;
use App\Models\Product;
use App\Models\SearchView;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogPage extends Component
{
    use WithPagination;

    #[Url]
    public array $selectedManufacturers = [];

    #[Url]
    public bool $inStockOnly = false;

    #[Url]
    public bool $onSaleOnly = false;

    #[Url]
    public string $search = '';

    public string $searchManufacturers = '';
    public int $page = 1;
    public  $productsCount;
    public array $searchHistory = [];

    public Collection $products;
    public Collection $manufacturers;

    public function mount(): void
    {
        $this->loadManufacturers();
        $this->loadSearchHistory();
        $this->addBreadcrumbs();

        if ($this->selectedManufacturers or $this->onSaleOnly or $this->inStockOnly or $this->search) {
            $this->applyFilters();
        } else {
            $this->loadProducts();
        }
    }

    public function loadSearchHistory(): void
    {
        $this->searchHistory = session()->get('search_history', []);
    }

    public function applyFilters(): void
    {
        $query = Product::query()
            ->with(['manufacturer', 'productSubstitutions'])
            ->select(['id', 'name', 'manufacturer_id', 'sku', 'oem'])
            ->orderBy('id');

        if ($this->search) {
            SearchView::query()->updateOrCreate(
                ['query' => $this->search, 'page' => 'Каталог'],
                ['count' => 1]
            )->increment('count');

            $this->addToSearchHistory($this->search);
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
            collect($this->selectedManufacturers)->each(function ($manufacturer) {
                ManufacturerView::query()
                    ->updateOrCreate(['manufacturer_id' => $manufacturer], ['views_count' => 0])
                    ->increment('views_count');
            });

            $query->whereIn('manufacturer_id', $this->selectedManufacturers);
        }

        if ($this->onSaleOnly) {
            $query->where('on_sale', true);
        }

        if ($this->inStockOnly) {
            $query->whereHas('warehouseProducts', function ($query) {
                return $query->where('quantity', '>', 0);
            });
        }

        $this->products = $query->limit($this->page * 30)->get();
    }

    public function addToSearchHistory(string $query): void
    {
        // Чистим запрос
        $query = trim($query);

        // Пропускаем слишком короткие запросы
        if (strlen($query) < 2) {
            return;
        }

        // Пропускаем пустые
        if (empty($query)) {
            return;
        }

        // Получаем текущую историю
        $history = session()->get('search_history', []);

        // Удаляем этот запрос если он уже есть (чтобы переместить в начало)
        $history = array_filter($history, fn($item) => $item !== $query);

        // Добавляем в начало
        array_unshift($history, $query);

        // Ограничиваем до 10 записей
        $history = array_slice($history, 0, 10);

        // Сохраняем в сессию
        session()->put('search_history', $history);

        // Обновляем свойство компонента
        $this->searchHistory = $history;
    }

    public function searchFromHistory(string $query): void
    {
        $this->search = $query;
        $this->applyFilters();
    }

    public function removeFromHistory(string $query): void
    {
        $history = session()->get('search_history', []);

        // Удаляем запрос
        $history = array_filter($history, fn($item) => $item !== $query);

        // Переиндексируем массив
        $history = array_values($history);

        // Сохраняем в сессию
        session()->put('search_history', $history);

        // Обновляем свойство компонента
        $this->searchHistory = $history;
    }

    public function clearSearchHistory(): void
    {
        // Очищаем сессию
        session()->forget('search_history');

        // Очищаем свойство компонента
        $this->searchHistory = [];
    }


//    public function loadMore(): void
//    {
//        $this->page++;
//        dd($this->products);
//    }
//
//    public function getHasMoreProperty()
//    {
//        $total = $this->products->count();
//        $shown = count($this->notifications);
//
//        return $total > $shown;
//    }

    public function updatedSearchManufacturers(): void
    {
        if ($this->searchManufacturers) {
            $this->manufacturers = Manufacturer::query()
                ->where('name', 'like', $this->searchManufacturers . '%')
                ->limit(30)
                ->get();
        } else {
            $selectedManufacturers = Manufacturer::query()
                ->whereIn('id', $this->selectedManufacturers)
                ->get();

            $otherManufacturers = Manufacturer::query()
                ->where('is_active', true)
                ->whereNotIn('id', $this->selectedManufacturers)
                ->limit(30 - $selectedManufacturers->count())
                ->get();

            $this->manufacturers = $selectedManufacturers->merge($otherManufacturers);
        }
    }

    public function resetFilters(): void
    {
        $this->selectedManufacturers = [];
        $this->inStockOnly = false;
        $this->onSaleOnly = false;

        $this->loadProducts();
    }

    public function loadProducts(): void
    {
        $this->products = Product::query()
            ->with(['manufacturer', 'productSubstitutions'])
            ->whereNot('product_warehouse_status_id', 3)
            ->limit($this->page * 30)
            ->get();
    }

    public function loadManufacturers(): void
    {
        $this->manufacturers = Manufacturer::query()
            ->where('is_active', true)
            ->limit(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.pages.multi.catalog.catalog-page');
    }

    public function addBreadcrumbs(): void
    {
        $this->dispatch('updateBreadcrumbs',
            items: [
                [
                    'label' => 'Каталог',
                    'active' => true
                ],
            ]
        );
    }
}
