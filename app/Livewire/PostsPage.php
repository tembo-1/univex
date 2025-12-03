<?php
// app/Livewire/PostsPage.php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostsPage extends Component
{
    use WithPagination;

    public function render()
    {
        $posts = Post::query()
            ->orderBy('published_at', 'desc')
            ->paginate(24);

        return view('livewire.posts-page', compact('posts'));
    }
}
