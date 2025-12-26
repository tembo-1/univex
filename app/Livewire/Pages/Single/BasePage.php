<?php

namespace App\Livewire\Pages\Single;

use App\Jobs\ProductOriginalsJob;
use App\Jobs\SyncCLEItemsJob;
use App\Jobs\SyncCLEJob;
use App\Jobs\SyncClientsJob;
use App\Jobs\SyncProductPricesJob;
use App\Jobs\SyncProductsJob;
use App\Jobs\SyncProductSubstitutionsJob;
use App\Jobs\SyncProductUserPricesJob;
use App\Jobs\SyncWarehouseProductsJob;
use App\Models\SitePage;
use Livewire\Component;

class BasePage extends Component
{
    public $page;
    public $blocks;

    public function mount(string $slug)
    {
////        SyncCLEJob::dispatch();
////        SyncCLEItemsJob::dispatch();
//        SyncClientsJob::dispatch();
//        SyncProductsJob::dispatch();
//        SyncProductPricesJob::dispatch();
//        SyncProductUserPricesJob::dispatch();
//        ProductOriginalsJob::dispatch();
//        SyncProductSubstitutionsJob::dispatch();
//        SyncWarehouseProductsJob::dispatch();
//        dd(123);


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
