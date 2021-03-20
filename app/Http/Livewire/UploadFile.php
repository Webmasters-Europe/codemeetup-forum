<?php

namespace App\Http\Livewire;


use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;

class UploadFile extends Component
{
    use WithFileUploads;

    public $category_id = -1;
    public $title;
    public $content;
    public $files = [];
        
    
    public function store() 
    { 
       
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'category_id' => 'required',
            'files.*' => 'image|max:3000',
        ]);

        $post = new Post([
            'title' => $this->title,
            'content' => $this->content,
        ]);
        
        $post->category()->associate($this->category_id);

        auth()->user()->posts->save($post);

        foreach ($this->files as $file) {
            $file->store('uploads');
            //TODO: save filename in DB
        }

        return redirect()->route('category.show', $post->category->id)->withStatus('Post successfully created.');

    }


    public function render()
    {
        return view('livewire.upload-file');
    }
}
