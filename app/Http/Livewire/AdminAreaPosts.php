<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class AdminAreaPosts extends TableComponent
{
    //public ;
    public $post;
    public $title;
    public $userName;
    public $replyCount;

    // Actions:
    public $action;
    public $showDeletedPosts;
    public $selectedPost;
    public $showPost;

    // Ordering:
    public $sortBy = 'category_id';
    public $sortDirection = 'asc';

    // Search fields:
    public $globalSearch = '';
    public $searchName = '';
    public $searchUsername = '';
    public $searchEmail = '';

    public function render()
    {
        if ($this->showDeletedPosts) {
            $posts = Post::onlyTrashed()->with('repliesTrashed');
        } else {
            $posts = Post::with('reply');
        }

        // Ordering:
        $posts = $posts->orderBy($this->sortBy, $this->sortDirection);

        // Pagination:
        $posts = $posts->paginate($this->paginate);

        return view('livewire.admin-area-posts', compact('posts'));
    }

    public function selectPost($id, $action): void
    {
        $this->selectedPost = $id;
        $post = Post::withTrashed()->with('reply')->findOrFail($this->selectedPost);
        $this->title = $post->title;
        $this->userName = $post->user->name;
        $this->replyCount = count($post->reply);
        $this->dispatchBrowserEventByAction($action);
    }

    public function delete(): \Illuminate\Http\RedirectResponse
    {
        Post::findOrFail($this->selectedPost)->delete();
        $this->dispatchBrowserEvent('closeDeleteModelInstanceModal');
        $this->resetInputFields();
        session()->flash('status', __('Post and all replies and comments in this post successfully deleted.'));

        return redirect()->route('admin-area.posts');
    }

    public function restore(): \Illuminate\Http\RedirectResponse
    {
        Post::onlyTrashed()->findOrFail($this->selectedPost)->restore();
        $this->dispatchBrowserEvent('closeRestoreModelInstanceModal');
        $this->resetInputFields();
        session()->flash('status', __('Post successfully restored.'));

        return redirect()->route('admin-area.posts');
    }

    public function update(): \Illuminate\Http\RedirectResponse
    {
        $this->validate();
        $post = Post::findOrFail($this->selectedPost);
        $post->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        $this->dispatchBrowserEvent('closeUpdateModelInstanceModal');
        $this->resetInputFields();
        session()->flash('status', __('Post successfully updated.'));

        return redirect()->route('admin-area.posts');
    }

    private function resetInputFields(): void
    {
        $this->title = '';
        $this->userName = '';
        $this->replyCount = '';
    }
}
