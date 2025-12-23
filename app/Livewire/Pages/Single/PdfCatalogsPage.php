<?php

namespace App\Livewire\Pages\Single;

use App\Models\Catalog;
use Illuminate\Support\Collection;
use Livewire\Component;

class PdfCatalogsPage extends Component
{
    public string $search = '';
    public Collection $catalogs;

    public function mount()
    {
        $this->catalogs = $this->Catalogs();

        $this->addBreadcrumbs();
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
        return view('livewire.pages.single.pdf-catalogs-page');
    }

    public function addBreadcrumbs(): void
    {
        $this->dispatch('updateBreadcrumbs',
            items: [
                [
                    'label' => 'Каталоги в PDF',
                    'active' => true
                ],
            ]
        );
    }
}
