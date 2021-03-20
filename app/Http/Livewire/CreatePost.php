<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\Upload;
use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;

class CreatePost extends Component
{
    use WithFileUploads;

    public $category_id = -1;
    public $title;
    public $content;
    public $files = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required',
        'category_id' => 'required',
        'files.*' => 'image|max:5000',
    ];

    public function submitForm()
    {
        $this->validate();

        $post = new Post([
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $post->category()->associate($this->category_id);
        
        auth()->user()->posts()->save($post);

        foreach ($this->files as $file) {
            $filename = $file->store('uploads');
            $upload = new Upload([
                'filename' => basename($filename)
            ]);
            $upload->post()->associate($post->id);
            $upload->save();
        }
        session()->flash('status', 'Post successfully created.');
        return redirect()->route('category.show', $post->category->id);
    }

    public function render()
    {
        $categories = Category::all()->sortBy('name');

        return view('livewire.create-post', compact('categories'));
    }
}
