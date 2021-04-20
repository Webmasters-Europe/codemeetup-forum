<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class LastPosts extends Component
{
    public function render()
    {
        return view('livewire.last-posts', [
            'posts' => Post::orderBy('created_at', 'desc')->limit(5)->get(),
        ]);
    }
}
