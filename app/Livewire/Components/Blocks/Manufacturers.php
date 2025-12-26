<?php

namespace App\Livewire\Components\Blocks;

use App\Models\Manufacturer;
use Illuminate\Support\Collection;
use Livewire\Component;

class Manufacturers extends Component
{
    public Collection $manufacturers;
    public string $title;

    public function mount()
    {
        $this->manufacturers = Manufacturer::query()
            ->limit(12)
            ->get();
    }

    public function render()
    {
        return view('livewire.components.blocks.manufacturers');
    }
}
