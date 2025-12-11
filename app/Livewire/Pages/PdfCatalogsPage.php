<?php

namespace App\Livewire\Pages;

use App\Models\Catalog;
use Livewire\Component;

class PdfCatalogsPage extends Component
{
    public $search = '';
    public $catalogs;

    public function mount()
    {
        $this->catalogs = $this->Catalogs();
    }

    private function Catalogs()
    {
        return Catalog::query()
            ->with('catalogFiles')
            ->where('is_active', 1)
            ->when($this->search, function ($query) {
                return $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhereHas('catalogFiles', function ($fileQuery) {
                            $fileQuery->where('name', 'like', "%{$this->search}%");
                        });
                });
            })
            ->get();
    }

    public function updatedSearch()
    {
        $this->catalogs = $this->Catalogs();
    }

    public function searchCatalogs()
    {
        $this->catalogs = $this->Catalogs();
    }

    public function render()
    {
        return view('livewire.pdf-catalogs-page');
    }
}
