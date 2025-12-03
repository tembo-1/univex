<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;

class PostPage extends Component
{
    public Post $post;
    public $relatedPosts;

    public function mount(string $slug)
    {
        $this->post = Post::query()
            ->firstWhere('slug', $slug);

        $this->relatedPosts = Post::query()->limit(4)->get();
    }

    public function render()
    {
        return view('livewire.post-page'); // Динамический title
    }
}
