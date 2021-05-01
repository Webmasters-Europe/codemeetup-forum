<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Reply;

class AdminAreaSinglePost extends Component
{
    public $postId;
    public $post;

    public function mount($postId)
    {
        $this->postId = $postId;
        $this->post = Post::findOrFail($this->postId);
    }

    public function render()
    {

        $replies = $this->post->reply()->paginate(3);
        $uploads = $this->post->uploads()->get();
        $images = [];
        $otherFiles = [];
        foreach ($uploads as $upload) {
            if ($this->isImage($upload->filename)) {
                array_push($images, $upload);
            } else {
                array_push($otherFiles, $upload);
            }
        }

        return view('livewire.admin-area-single-post', compact('replies', 'images', 'otherFiles'));
    }

    public function selectPost($id, $action)
    {
        $this->selectedPost = $id;

        $post = Post::withTrashed()->with('reply')->findOrFail($this->selectedPost);

        $this->title = $post->title;
        $this->userName = $post->user->name;
        $this->replyCount = count($post->reply);

        $this->dispatchBrowserEventByAction($action);
    }
}
