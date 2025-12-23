<?php

namespace App\Livewire\Components\Blocks;

use App\Models\Menu;
use Illuminate\Support\Str;
use Livewire\Component;

class Header extends Component
{
    public bool $isAuth;
    public string $userName;
    public $menus;

    public function mount()
    {
        $this->isAuth = auth()->check();
        $this->getUserName();

        $this->menus = Menu::query()
            ->with(['menuItems', 'menuItems.sitePage'])
            ->where('is_active', true)
            ->get();
    }
    public function render()
    {
        return view('livewire.components.blocks.header');
    }

    public function getUserName()
    {
        if ($this->isAuth) {
            $this->userName = Str::limit(auth()->user()->client->short_name, 15);
        }
    }
}
