<?php

namespace App\Livewire\Pages;

use App\Models\SitePage;
use Livewire\Component;

class ContractsPage extends Component
{
    public string $content;

    public function mount()
    {
        $this->content = SitePage::query()
            ->firstWhere('slug', 'contracts')
            ->siteBlocks
            ->firstWhere('name', 'Договоры')
            ->siteElements
            ->first()
            ->cleanContent;
    }

    public function render()
    {
        return view('livewire.contracts-page');
    }
}
