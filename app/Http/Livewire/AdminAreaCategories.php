<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithPagination;

class AdminAreaCategories extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = '';
    public $name;
    public $description;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
    ];


    public function render()
    {
        $categories = Category::search(trim($this->search))->orderBy('created_at','DESC')->paginate($this->paginate);
        return view('livewire.admin-area-categories', compact('categories'));
    }

    
    public function showCategoryForm(){
        $this->dispatchBrowserEvent('show-form');
    }

    public function addNewCategory(){
        
        $this->validate();

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->dispatchBrowserEvent('hide-form');
        $this->name = '';
        $this->description = '';

        session()->flash('status', 'Category successfully created.');
        return redirect()->back();
        
    }

}
