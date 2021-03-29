<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class AdminAreaCategories extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $paginate = 10;
    public $search = '';
    public $searchName = '';
    public $searchDescription = '';
    public $name;
    public $description;
    public $showDeletedCategories;
    public $selectedCategory;
    public $action;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string|max:255',
    ];

    public function render()
    {
        if ($this->showDeletedCategories) {
            $categories = Category::onlyTrashed()
            ->when($this->searchName, function ($query) {
                $query->searchName(trim($this->searchName));
            })
            ->when($this->searchDescription, function ($query) {
                $query->searchDescription(trim($this->searchDescription));
            })
            ->when($this->search, function ($query) {
                $query->search(trim($this->search));
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->paginate);
        } else {
            $categories = Category::query()
            ->when($this->searchName, function ($query) {
                $query->searchName(trim($this->searchName));
            })
            ->when($this->searchDescription, function ($query) {
                $query->searchDescription(trim($this->searchDescription));
            })
            ->when($this->search, function ($query) {
                $query->search(trim($this->search));
            })
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->paginate);
        }

        return view('livewire.admin-area-categories', compact('categories'));
    }

    public function sortBy($field)
    {
        if ($this->sortDirection == 'desc') {
            $this->sortDirection = 'asc';
        } else {
            $this->sortDirection = 'desc';
        }

        return $this->sortBy = $field;
    }

    public function showCategoryForm()
    {
        $this->resetInputFields();
        $this->dispatchBrowserEvent('openAddCategoryModal');
    }

    public function addNewCategory()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->dispatchBrowserEvent('closeAddCategoryModal');
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

        switch ($action) {
            case 'delete':
                $this->dispatchBrowserEvent('openDeleteModal');
                break;
            case 'update':
                $this->dispatchBrowserEvent('openUpdateModal');
                break;
            case 'restore':
                $this->dispatchBrowserEvent('openRestoreModal');
                break;
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
        $this->dispatchBrowserEvent('closeUpdateModal');
        $this->resetInputFields();
        session()->flash('status', 'Category successfully updated.');

        return redirect()->route('admin-area.categories');
    }

    public function delete()
    {
        Category::findOrFail($this->selectedCategory)->delete();
        $this->dispatchBrowserEvent('closeDeleteModal');
        $this->resetInputFields();
        session()->flash('status', 'Category and all posts and replies in this category successfully deleted.');

        return redirect()->route('admin-area.categories');
    }

    public function restore()
    {
        Category::onlyTrashed()->findOrFail($this->selectedCategory)->restore();
        $this->dispatchBrowserEvent('closeRestoreModal');
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
