<?php

namespace App\Livewire;

use Livewire\Component;

class Toast extends Component
{
    public $toasts = [];

    protected $listeners = ['showToast'];

    public function showToast($type, $message, $title = null)
    {
        $id = uniqid();

        $this->toasts[$id] = [
            'id' => $id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
        ];

        // Автоматически удалить через 5 секунд
        $this->dispatch('hide-toast', id: $id);
    }

    public function hide($id)
    {
        if (isset($this->toasts[$id])) {
            unset($this->toasts[$id]);
        }
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
