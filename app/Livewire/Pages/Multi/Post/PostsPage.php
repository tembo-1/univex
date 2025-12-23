<?php
// app/Livewire/PostsPage.php

namespace App\Livewire\Pages\Multi\Post;

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

        return view('livewire.pages.multi.post.posts-page', compact('posts'));
    }
}
