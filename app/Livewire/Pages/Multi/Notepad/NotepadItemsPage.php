<?php

namespace App\Livewire\Pages\Multi\Notepad;

use App\Models\Notepad;
use App\Models\NotepadItem;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class NotepadItemsPage extends Component
{
    use WithPagination;

    public Notepad $notepad;
    public int $perPage = 10;
    public string $period = '6';
    public string $sortType = 'date';

    #[Url]
    public string $search = '';

    public function mount(int $id)
    {
        $this->notepad = Notepad::query()
            ->find( $id);

        $this->addBreadcrumbs();
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function loadNotepadItems()
    {
        $query = NotepadItem::query()
            ->select('notepad_items.*')
            ->where('notepad_id', $this->notepad->id);

        $date = now();

        if ($this->period !== '6') {
            switch ($this->period) {
                case '1': $date = $date->subDay(); break;
                case '2': $date = $date->subWeek(); break;
                case '3': $date = $date->subMonth(); break;
                case '4': $date = $date->subMonths(3); break;
                case '5': $date = $date->subMonths(6); break;
            }
            $query->where('notepad_items.created_at', '>=', $date);
        }

        if ($this->search) {
            $searchTerm = $this->search . '%';

            $query->where(function($q) use ($searchTerm) {
                $q->whereHas('product', function($pq) use ($searchTerm) {
                    $pq->where('id', 'LIKE', $searchTerm)
                        ->orWhere('sku', 'LIKE', $searchTerm)
                        ->orWhere('name', 'LIKE', $searchTerm);
                })
                    ->orWhereHas('product.manufacturer', function($mq) use ($searchTerm) {
                        $mq->where('name', 'LIKE', $searchTerm);
                    });
            });
        }

        // ПОСЛЕ фильтра добавляем сортировку
        match($this->sortType) {
            'manufacturer' => $query
                ->leftJoin('products', 'notepad_items.product_id', '=', 'products.id')
                ->leftJoin('manufacturers', 'products.manufacturer_id', '=', 'manufacturers.id')
                ->orderBy('manufacturers.name', 'asc'),

            'sku' => $query
                ->leftJoin('products', 'notepad_items.product_id', '=', 'products.id')
                ->orderBy('products.sku', 'asc'),

            'name' => $query
                ->leftJoin('products', 'notepad_items.product_id', '=', 'products.id')
                ->orderBy('products.name', 'asc'),

            default => $query->orderBy('notepad_items.id', 'desc')
        };

        return $query->paginate($this->perPage);
    }

    public function remove(int $id)
    {
        NotepadItem::query()
            ->find($id)
            ->delete();
    }

    public function render()
    {
        return view('livewire.pages.multi.notepad.notepad-items-page', [
            'notepadItems' => $this->loadNotepadItems()
        ]);
    }

    public function addBreadcrumbs(): void
    {
        $this->dispatch('updateBreadcrumbs',
            items: [
                [
                    'label' => 'Блокнот',
                    'url'   => route('notepad'),
                    'active' => false
                ],
                [
                    'label' => $this->notepad->name,
                    'active' => true
                ],
            ]
        );
    }
}
