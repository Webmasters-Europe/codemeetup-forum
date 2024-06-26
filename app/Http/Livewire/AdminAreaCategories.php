<?php

namespace App\Http\Livewire;

use App\Models\Category;

class AdminAreaCategories extends TableComponent
{
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

    public function showCategoryForm(): void
    {
        $this->resetInputFields();
        $this->dispatchBrowserEvent('openAddModelInstanceModal');
    }

    // public function addNewCategory(): \Illuminate\Http\RedirectResponse
    public function addNewCategory(): \Livewire\Redirector
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->dispatchBrowserEvent('closeAddModelInstanceModal');
        $this->resetInputFields();

        session()->flash('status', __('Category successfully created.'));

        return redirect()->route('admin-area.categories');
    }

    public function selectCategory($categoryId, $action): void
    {
        $this->selectedCategory = $categoryId;
        $category = Category::withTrashed()->findOrFail($this->selectedCategory);
        $this->name = $category->name;
        $this->description = $category->description;

        $this->dispatchBrowserEventByAction($action);
    }

    // public function update(): \Illuminate\Http\RedirectResponse
    public function update(): \Livewire\Redirector
    {
        $this->validate();
        $category = Category::findOrFail($this->selectedCategory);
        $category->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        $this->dispatchBrowserEvent('closeUpdateModelInstanceModal');
        $this->resetInputFields();
        session()->flash('status', __('Category successfully updated.'));

        return redirect()->route('admin-area.categories');
    }

    // public function delete(): \Illuminate\Http\RedirectResponse
    public function delete(): \Livewire\Redirector
    {
        Category::findOrFail($this->selectedCategory)->delete();
        $this->dispatchBrowserEvent('closeDeleteModelInstanceModal');
        $this->resetInputFields();
        session()->flash('status', __('Category and all posts and replies in this category successfully deleted.'));

        return redirect()->route('admin-area.categories');
    }

    // public function restore(): \Illuminate\Http\RedirectResponse
    public function restore(): \Livewire\Redirector
    {
        Category::onlyTrashed()->findOrFail($this->selectedCategory)->restore();
        $this->dispatchBrowserEvent('closeRestoreModelInstanceModal');
        $this->resetInputFields();
        session()->flash('status', __('Category successfully restored.'));

        return redirect()->route('admin-area.categories');
    }

    private function resetInputFields(): void
    {
        $this->name = '';
        $this->description = '';
    }
}
