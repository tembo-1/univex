<?php

namespace App\Livewire\Components\Blocks;

use Livewire\Component;

class UserMenu extends Component
{
    public string $route;

    public function mount()
    {
        $this->route = request()->route()->getName();
    }

    public function render()
    {
        return view('livewire.components.blocks.user-menu');
    }
}
