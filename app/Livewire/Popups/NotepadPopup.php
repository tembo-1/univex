<?php

namespace App\Livewire\Popups;

use App\Models\Notepad;
use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;

class NotepadPopup extends Component
{
    public $name = '';
    public $error = '';

    #[Url]
    public $productSlug;

    public function render()
    {
        return view('components.popups.notepad');
    }

    public function submit()
    {
        if (!$this->name) {
            $this->error = 'Заполните имя';
        } else {
            $notepad = Notepad::query()
                ->create([
                    'name' => $this->name,
                    'user_id' => auth()->id(),
                ]);

            if ($this->productSlug) {
                $product = Product::query()
                    ->firstWhere('sku', $this->productSlug);

                if ($product) {
                    $notepad->notepadItems()->create([
                        'product_id' => $product->id
                    ]);
                }
            }

            redirect(url()->previous());
        }
    }
}
