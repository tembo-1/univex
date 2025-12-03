<?php

namespace App\Livewire;

use App\Models\Manufacturer;
use App\Models\Post;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class HomePage extends Component
{
    public Collection $posts;
    public Collection $manufacturers;

    public function mount()
    {
        $this->posts = Post::query()
            ->where('is_published', 1)
            ->where('is_visible', 1)
            ->get();

        $this->manufacturers = Manufacturer::query()
            ->where('is_visible', 1)
            ->get();

    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
