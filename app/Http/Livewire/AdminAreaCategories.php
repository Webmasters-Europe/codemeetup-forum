<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\WithPagination;

class AdminAreaCategories extends TableComponent
{
    public $search = '';
    public $searchName = '';
    public $searchDescription = '';
    public $name;
    public $description;
    public $showDeletedCategories = false;
    public $selectedCategory;
    public $action;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    // Modals
    public $showDeleteModal = false;
    public $showRestoreModal = false;
    public $showAddModal = false;
    public $showEditModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
    ];

    public function render()
    {
        if ($this->showDeletedCategories) {
            $categories = Category::onlyTrashed();
        } else {
            $categories = Category::query();
        }

        // Search filter:
        $categories = $categories
        ->when($this->searchName, function ($query) {
            $query->searchName(trim($this->searchName));
        })
        ->when($this->searchDescription, function ($query) {
            $query->searchDescription(trim($this->searchDescription));
        })
        ->when($this->search, function ($query) {
            $query->search(trim($this->search));
        });

        // Ordering:
        $categories = $categories->orderBy($this->sortBy, $this->sortDirection);

        // Pagination:
        $categories = $categories->paginate($this->paginate);
        
        return view('livewire.admin-area-categories', compact('categories'));
    }

    public function showCategoryForm()
    {
        $this->resetInputFields();
        $this->showAddModal = true;
    }

    public function addNewCategory()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->showAddModal = false;
        $this->resetInputFields();

        session()->flash('status', 'Category successfully created.');

        return redirect()->route('admin-area.categories');
    }

    public function selectCategory($categoryId, $action)
    {
       
        $this->selectedCategory = $categoryId;
        $category = Category::withTrashed()->findOrFail($this->selectedCategory);
        $this->name = $category->name;
        $this->description = $category->description;
        
        if($action == 'delete') {
            $this->showDeleteModal = true;
        }
        if($action == 'restore') {
            $this->showRestoreModal = true;
        }

        if($action == 'edit') {
            $this->showEditModal = true;
        } 

    }

    public function update()
    {
        $this->validate();
        $category = Category::findOrFail($this->selectedCategory);
        $category->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        $this->showEditModal = false;
        $this->resetInputFields();
        session()->flash('status', 'Category successfully updated.');

        return redirect()->route('admin-area.categories');
    }

    public function delete()
    {
        Category::findOrFail($this->selectedCategory)->delete();
        $this->resetInputFields();
        session()->flash('status', 'Category and all posts and replies in this category successfully deleted.');

        return redirect()->route('admin-area.categories');
    }

    public function restore()
    {
        Category::onlyTrashed()->findOrFail($this->selectedCategory)->restore();
        $this->resetInputFields();
        session()->flash('status', 'Category successfully restored.');

        return redirect()->route('admin-area.categories');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
    }

    
}