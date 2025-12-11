<?php

namespace App\Livewire\Page;

use App\Models\SitePage;
use Livewire\Component;

class BasePage extends Component
{
    public $page;
    public $blocks;

    public function mount(string $slug)
    {
        $this->page = SitePage::query()
            ->firstWhere('slug', $slug);

        if (!$this->page) {
            $this->redirect(route('404'));
        }

        $this->blocks = $this
            ->page
            ->siteBlocks;
    }
    public function render()
    {
        return view('livewire.page.base-page');
    }
}
