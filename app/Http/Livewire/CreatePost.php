<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\Upload;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;
    use AuthorizesRequests;

    public $category;
    public $title;
    public $content;
    public $files = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required',
        'files.*' => 'max:5000',
    ];

    public function submitForm()
    {
        $this->authorize('create', Post::class);

        $this->validate();

        $post = new Post([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $post->category()->associate($this->category);

        auth()->user()->posts()->save($post);

           
        foreach ($this->files as $file) {
            $filename = $file->store('uploads', 'public');
            $upload = new Upload([
                'filename' => $filename,
                'original_filename' => $file->getClientOriginalName(),
            ]);
            $upload->post()->associate($post->id);
            $upload->save();
        }
        session()->flash('status', __('Post successfully created.'));

        return redirect()->route('category.show', $post->category->id);
    }

    public function render()
    {
        return view('livewire.create-post');
    }
}
