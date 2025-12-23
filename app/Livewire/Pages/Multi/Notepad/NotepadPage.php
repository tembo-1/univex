<?php

namespace App\Livewire\Pages\Multi\Notepad;

use App\Models\Notepad;
use App\Models\NotepadItem;
use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class NotepadPage extends Component
{
    use WithPagination;

    #[Url]
    public string $productSlug = '';

    #[Url]
    public string $search = '';

    public $period = '6';
    public $sort = '4';

    public int $perPage = 9;
    public int $page = 1;
    public Collection $loadedNotepads;

    public function mount()
    {
        $this->loadedNotepads = collect();

        $this->loadNotepads();
        $this->addBreadcrumbs();
    }

    public function loadNotepads()
    {
        $query = Notepad::query()
            ->where('user_id', auth()->id());
        $date = now();

        if ($this->period !== '6') {
            switch ($this->period) {
                case '1': $date = $date->subDay(); break;
                case '2': $date = $date->subWeek(); break;
                case '3': $date = $date->subMonth(); break;
                case '4': $date = $date->subMonths(3); break;
                case '5': $date = $date->subMonths(6); break;
            }
            $query->where('created_at', '>=', $date);
        }

        if ($this->search) {
            $query->where('name','like', '%' . $this->search . '%');
        }

        if ($this->sort !== '4') {
            switch ($this->sort) {
                case '4': $query->orderBy('name'); break;
                case '5': $query->orderBy('created_at', 'asc'); break;
                case '6': $query->orderBy('created_at', 'desc'); break;
            }
        }

        $this->loadedNotepads = $query
            ->limit($this->page * $this->perPage)
            ->get();
    }

    public function loadMore()
    {
        $this->page++;
        $this->loadNotepads();
    }

    public function showToast()
    {
        if ($this->productSlug) {
            $this->dispatch('showToast',
                type: 'warning',
                message: 'Выберите блокнот или создайте новый, чтобы поместить товар в него!'
            );
        }
    }

    public function getHasMoreProperty()
    {
        $query = Notepad::query()
            ->where('user_id', auth()->id());
        $date = now();

        if ($this->period !== '6') {
            switch ($this->period) {
                case '1': $date = $date->subDay(); break;
                case '2': $date = $date->subWeek(); break;
                case '3': $date = $date->subMonth(); break;
                case '4': $date = $date->subMonths(3); break;
                case '5': $date = $date->subMonths(6); break;
            }
            $query->where('created_at', '>=', $date);
        }

        if ($this->search) {
            $query->where('name','like', '%' . $this->search . '%');
        }

        $total = $query->count();
        $shown = count($this->loadedNotepads);

        return $total > $shown;
    }

    public function updatedSearch($value)
    {
        $this->search = $value;
        $this->page = 1;
        $this->loadNotepads();
    }

    public function updatedPeriod($value)
    {
        $this->period = $value;
        $this->page = 1;
        $this->loadNotepads();
    }

    public function updatedSort($value)
    {
        $this->sort = $value;
        $this->page = 1;
        $this->loadNotepads();
    }

    public function addToNotepad(int $id)
    {
        $notepad = Notepad::query()
            ->find($id);

        if ($this->productSlug) {
            $product = Product::query()
                ->firstWhere('sku', $this->productSlug);

            if ($product) {
                $notepadItem = NotepadItem::query()
                    ->firstWhere([
                        ['notepad_id', $notepad->id],
                        ['product_id', $product->id]
                    ]);

                if (!$notepadItem) {
                    $notepad->notepadItems()->create([
                        'product_id' => $product->id,
                    ]);

                    $this->dispatch('showToast',
                        type: 'success',
                        message: 'Товар добавлен в данный блокнот'
                    );
                } else {
                    $this->dispatch('showToast',
                        type: 'warning',
                        message: 'Товар уже добавлен в этот блокнот'
                    );
                }

                $this->productSlug = '';
            }
        } else {
            $this->redirect(route('notepad.items', $notepad->id));
        }
    }

    public function render()
    {
        return view('livewire.pages.multi.notepad.notepad-page', [
            'notepads' => $this->loadedNotepads,
            'hasMore' => $this->hasMore,
        ]);
    }

    public function addBreadcrumbs(): void
    {
        $this->dispatch('updateBreadcrumbs',
            items: [
                [
                    'label' => 'Блокнот',
                    'active' => true
                ],
            ]
        );
    }
}
