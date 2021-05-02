<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class LastPosts extends Component
{
    public function render()
    {
        $numberLastPosts = config('app.settings.number_last_entries_startpage');

        return view('livewire.last-posts', [
            'posts' => Post::orderBy('created_at', 'desc')->limit($numberLastPosts)->get(),
        ]);
    }
}
