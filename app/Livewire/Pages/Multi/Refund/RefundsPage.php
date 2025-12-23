<?php

namespace App\Livewire\Pages\Multi\Refund;

use App\Models\Refund;
use Illuminate\Support\Collection;
use Livewire\Component;

class RefundsPage extends Component
{
    public Collection $refunds;

    public function mount()
    {
        $this->refunds = Refund::query()
            ->get();
    }
    public function render()
    {
        return view('livewire.pages.multi.refund.refunds-page');
    }
}
