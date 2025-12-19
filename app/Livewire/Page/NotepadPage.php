<?php

namespace App\Livewire\Page;

use App\Models\Notepad;
use App\Models\NotepadItem;
use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Attributes\Url;
use Livewire\Component;

class NotepadPage extends Component
{
    #[Url]
    public $productSlug;

    public $search;

    public $period = '6';
    public $sort = '4';
    protected $listeners = ['sort-changed' => 'handleSortChanged'];

    public Collection $notepads;

    public function handleSortChanged($value)
    {
        $this->sort = $value;
        $this->loadNotepads();
    }


    public function mount()
    {
        $this->loadNotepads();
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
                case '3': $query->orderBy('created_at'); break;
                case '5': $query->orderBy('created_at', 'asc'); break;
                case '6': $query->orderBy('created_at', 'desc'); break;
            }
        }

        $this->notepads = $query->get();
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

    public function updatedPeriod($value)
    {
        $this->period = $value;
        $this->loadNotepads();
    }

    public function updatedSort($value)
    {
        $this->sort = $value;
        $this->loadNotepads();
    }

    public function updatedSearch($value)
    {
        $this->search = $value;
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
        return view('livewire.page.notepad-page');
    }
}
