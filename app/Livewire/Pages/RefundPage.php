<?php

namespace App\Livewire\Pages;

use App\Models\SitePage;
use Livewire\Component;

class RefundPage extends Component
{
    public string $content;

    public function mount()
    {
        $this->content = SitePage::query()
            ->firstWhere('slug', 'refund')
            ->siteBlocks
            ->firstWhere('name', 'Текст правил')
            ->siteElements
            ->first()
            ->cleanContent;
    }

    public function render()
    {
        return view('livewire.refund-page');
    }
}
