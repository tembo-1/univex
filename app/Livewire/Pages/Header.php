<?php

namespace App\Livewire\Pages;

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
                ->where('is_active', true)
                ->get();
    }
    public function render()
    {
        return view('livewire.header');
    }

    public function getUserName()
    {
        if ($this->isAuth) {
            $this->userName = Str::limit(auth()->user()->client->short_name, 15);
        }
    }
}
