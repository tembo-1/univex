<?php

namespace App\Livewire\Pages;

use App\Models\SitePage;
use Livewire\Component;

class BecomeSupplier extends Component
{
    public string $content;

    public function mount()
    {
        $this->content = SitePage::query()
            ->firstWhere('slug', 'become-supplier')
            ->siteBlocks
            ->firstWhere('name', 'Как стать поставщиком')
            ->siteElements
            ->first()
            ->cleanContent;
    }

    public function render()
    {
        return view('livewire.become-supplier');
    }
}
