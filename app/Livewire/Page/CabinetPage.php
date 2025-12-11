<?php

namespace App\Livewire\Page;

use Livewire\Component;

class CabinetPage extends Component
{
    public string $name;
    public string $id;
    public string $inn;
    public string $phone;
    public string $email;
    public $manager;
    public $notifications;

    public function mount()
    {
        $this->name     = auth()->user()->client->short_name;
        $this->id       = auth()->id();
        $this->inn      = auth()->user()->client->inn;
        $this->phone    = auth()->user()->client->phone ?? '';
        $this->email    = auth()->user()->email;
        $this->manager = auth()->user()->client->employee;
    }

    public function render()
    {
        return view('livewire.page.cabinet-page');
    }
}
