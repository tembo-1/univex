<?php

namespace App\Livewire\Pages;

use App\Models\Manufacturer;
use App\Models\SitePage;
use Livewire\Component;

class AboutPage extends Component
{
    public $manufacturers;
    public $siteBlocks;

    public function mount(): void
    {
        $this->siteBlocks = SitePage::query()
            ->with(['siteBlocks.siteElements'])
            ->firstWhere('slug', 'about')
            ->siteBlocks;

        $this->manufacturers = Manufacturer::query()
            ->where('is_visible', 1)
            ->limit(12)
            ->get();
    }
    public function render()
    {
        return view('livewire.about-page');
    }
}
