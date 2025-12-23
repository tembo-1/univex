<?php

namespace App\Livewire\Popups;

use App\Models\NotepadItem;
use Livewire\Component;

class NotepadComment extends Component
{
    public $notepadItem;
    public ?string $comment = '';
    public $error = '';

    public function mount($id) // Принимаем через mount
    {
        $this->notepadItem = NotepadItem::query()
            ->find($id);

        $this->comment = $this->notepadItem->comment;
    }

    public function submit()
    {
        if ($this->comment === '') {
            $this->error = 'Заполните комментарий';
        } else {
            $this->notepadItem->update([
                'comment' => $this->comment
            ]);

            $this->dispatch('showToast',
                type: 'success',
                message: 'Комментарий оставлен'
            );
        }

    }

    public function render()
    {
        return view('components.popups.notepad-comment');
    }
}
