<?php

namespace App\Livewire\Pages;

use App\Models\Menu;
use App\Models\SitePage;
use Livewire\Component;

class Footer extends Component
{
    public $menus;
    public $privacyPolicyUrl;

    public function mount(): void
    {
        $this->menus = Menu::query()
            ->where('is_active', true)
            ->where('on_footer', true)
            ->get();

        $this->privacyPolicyUrl = SitePage::query()
            ->firstWhere('slug', 'privacy-policy')
            ?->url;
    }

    public function render()
    {
        return view('livewire.footer');
    }
}
