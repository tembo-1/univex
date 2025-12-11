<?php
// app/Livewire/PostsPage.php

namespace App\Livewire\Pages;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class PostsPage extends Component
{
    use WithPagination;

    public function render()
    {
        $posts = Post::query()
            ->orderBy('starts_at', 'desc')
            ->active()
            ->paginate(24);

        return view('livewire.posts-page', compact('posts'));
    }
}
