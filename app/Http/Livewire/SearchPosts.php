<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class SearchPosts extends Component
{
    public $search = '';

    public function render()
    {
        return view('livewire.search-posts');
        // return view('livewire.search-posts', [
        //     'posts' => Post::search($this->search, ['title', 'content']),
        // ]);
    }
}
