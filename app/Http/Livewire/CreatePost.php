<?php

namespace App\Http\Livewire;

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

        'category_id' => 'required',
    ];

    public function submitForm()
    {
        $this->validate();
        /**
         * Todo Save Form
         */
    }


    public function render()
    {
        $categories = Category::all()->sortBy('name');
        return view('livewire.create-post', compact('categories'));
    }
}
