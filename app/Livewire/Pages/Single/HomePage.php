<?php

namespace App\Livewire\Pages\Single;

use App\Models\Post;
use App\Models\SitePage;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class HomePage extends Component
{
    public Collection $posts;
    public Collection $manufacturers;
    public SitePage $page;
    public Collection $blocks;

    public function mount()
    {
        $this->posts = Post::query()
            ->where('is_visible', true)
            ->active()
            ->get();

        $this->page = SitePage::query()
            ->firstWhere('slug', 'home');

        $this->blocks = $this->page->siteBlocks()
            ->with('siteElements')
            ->get();
    }

    public function getTitle()
    {
        return $this->page->title;
    }

    public function getDescription()
    {
        return $this->page->meta_description;
    }

    public function getKeywords()
    {
        return $this->page->meta_keywords;
    }

    public function render()
    {
        return view('livewire.pages.single.home-page')
            ->layout('layouts.app', [
                'title'         => $this->getTitle(),
                'description'   => $this->getTitle(),
                'keywords'      => $this->getTitle(),
            ]);
    }
}
