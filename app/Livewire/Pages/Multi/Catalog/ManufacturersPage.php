<?php

namespace App\Livewire\Pages\Multi\Catalog;

use App\Models\Manufacturer;
use Livewire\Attributes\Url;
use Livewire\Component;

class ManufacturersPage extends Component
{
    #[Url]
    public $search = '';

    public $page = 1;
    public $perPage = 24;
    public $loadedManufacturers = [];

    public function mount()
    {
        $this->loadManufacturers();
        $this->addBreadcrumbs();
    }

    public function loadManufacturers()
    {
        $query = Manufacturer::query()
            ->where('is_active', true);

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $totalManufacturers = $query->count();

        $this->loadedManufacturers = $query
            ->limit($this->page * $this->perPage)
            ->get();
    }

    public function loadMore()
    {
        $this->page++;
        $this->loadManufacturers();
    }

    public function updatedSearch()
    {
        $this->page = 1;
        $this->loadManufacturers();
    }

    public function getHasMoreProperty()
    {
        $query = Manufacturer::query()
            ->orderByDesc('position')
            ->where('is_active', true);

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        $total = $query->count();
        $shown = count($this->loadedManufacturers);

        return $total > $shown;
    }

    public function render()
    {
        return view('livewire.pages.multi.catalog.manufacturers-page', [
            'manufacturers' => $this->loadedManufacturers,
            'hasMore' => $this->hasMore,
        ]);
    }

    public function addBreadcrumbs(): void
    {
        $this->dispatch('updateBreadcrumbs',
            items: [
                [
                    'label' => 'Производители',
                    'active' => true
                ],
            ]
        );
    }
}
