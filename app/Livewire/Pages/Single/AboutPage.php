<?php

namespace App\Livewire\Pages\Single;

use App\Models\Manufacturer;
use App\Models\SitePage;
use Illuminate\Support\Collection;
use Livewire\Component;

class AboutPage extends Component
{
    public Collection $manufacturers;
    public Collection $siteBlocks;

    public function mount(): void
    {
        $this->siteBlocks = SitePage::query()
            ->with(['siteBlocks.siteElements'])
            ->firstWhere('slug', 'about')
            ->siteBlocks;

        $this->manufacturers = Manufacturer::query()
            ->limit(12)
            ->get();

        $this->addBreadcrumbs();
    }
    public function render()
    {
        return view('livewire.pages.single.about-page');
    }

    public function addBreadcrumbs(): void
    {
        $this->dispatch('updateBreadcrumbs',
            items: [
                [
                    'label' => 'О компании',
                    'active' => true
                ],
            ]
        );
    }
}
