<?php

namespace App\Livewire\Pages\Single;

use App\Jobs\SyncClientsJob;
use App\Jobs\SyncProductsJob;
use App\Models\SitePage;
use Livewire\Component;

class BasePage extends Component
{
    public $page;
    public $blocks;

    public function mount(string $slug)
    {
        SyncProductsJob::dispatchSync();

        $this->page = SitePage::query()
            ->firstWhere('slug', $slug);

        if (!$this->page) {
            return $this->redirect(route('404'));
        }

        $this->blocks = $this
            ->page
            ->siteBlocks;
    }
    public function render()
    {
        return view('livewire.pages.single.base-page');
    }
}
