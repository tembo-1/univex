<?php

namespace App\Livewire\Pages;

use App\Models\Manufacturer;
use Livewire\Attributes\Url;
use Livewire\Component;

class ManufacturersPage extends Component
{
    #[Url]
    public $search = '';

    public $page = 1;
    public $perPage = 12;
    public $loadedManufacturers = [];

    public function mount()
    {
        $this->loadManufacturers();
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

        // Если нужно инициализировать анимации для новых элементов
        $this->dispatch('manufacturers-loaded');
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
        return view('livewire.manufacturers-page', [
            'manufacturers' => $this->loadedManufacturers,
            'hasMore' => $this->hasMore,
        ]);
    }
}
