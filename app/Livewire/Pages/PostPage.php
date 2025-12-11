<?php

namespace App\Livewire\Pages;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class PostPage extends Component
{
    public Post $post;
    public Collection $relatedPosts;

    public function mount(string $slug)
    {
        $this->post = Post::query()
            ->firstWhere('slug', $slug);

        $this->relatedPosts = Post::query()
            ->whereNot('slug', $slug)
            ->inRandomOrder()
            ->active()
            ->limit(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.post-page'); // Динамический title
    }
}
