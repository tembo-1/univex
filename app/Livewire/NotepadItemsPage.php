<?php

namespace App\Livewire;

use App\Models\Notepad;
use Illuminate\Support\Collection;
use Livewire\Component;

class NotepadItemsPage extends Component
{
    public Notepad $notepad;
    public Collection $notepadItems;


    public function mount(int $id)
    {
        $this->notepad = Notepad::query()
            ->find( $id);

        $this->notepadItems = $this->notepad->notepadItems;
    }
    public function render()
    {
        return view('livewire.notepad-items-page');
    }
}
