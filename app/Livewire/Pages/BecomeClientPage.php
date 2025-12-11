<?php

namespace App\Livewire\Pages;

use App\Models\SitePage;
use Livewire\Component;

class BecomeClientPage extends Component
{
    public string $content;

    public function mount()
    {
        $this->content = SitePage::query()
            ->firstWhere('slug', 'become-client')
            ->siteBlocks
            ->firstWhere('name', 'Как стать клиентом')
            ->siteElements
            ->first()
            ->cleanContent;
    }

    public function render()
    {
        return view('livewire.become-customer-page');
    }
}
