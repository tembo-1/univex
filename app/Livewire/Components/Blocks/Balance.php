<?php

namespace App\Livewire\Components\Blocks;

use Livewire\Component;

class Balance extends Component
{
    public $balance = 0;
    public $creditLimit = 0;
    public $debt = 0;
    public $availableBalance = 0;
    public $defermentDays = 0;

    public function render()
    {
        return view('livewire.components.blocks.balance');
    }
}
