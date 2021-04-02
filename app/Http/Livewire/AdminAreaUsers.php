<?php

namespace App\Http\Livewire;

use App\Models\User;

class AdminAreaUsers extends TableComponent
{
    // Ordering:
    public $sortBy = 'username';
    public $sortDirection = 'asc';

    // Search fields:
    public $globalSearch = '';
    public $searchName = '';
    public $searchUsername = '';
    public $searchEmail = '';

    // Form fields:
    public $name;
    public $username;
    public $email;

    // Actions:
    public $action;
    public $showDeletedElements;
    public $selectedModelInstance;

    public function render()
    {
        if ($this->showDeletedElements) {
            $users = User::onlyTrashed();
        } else {
            $users = User::query();
        }

        // Search filter:
        $users = $users
            ->when($this->globalSearch, function ($query) {
                $query->globalSearch(trim($this->globalSearch));
            })
            ->when($this->searchName, function ($query) {
                $query->singleFieldSearch(trim($this->searchName), 'name');
            })
            ->when($this->searchUsername, function ($query) {
                $query->singleFieldSearch(trim($this->searchUsername), 'username');
            })
            ->when($this->searchEmail, function ($query) {
                $query->singleFieldSearch(trim($this->searchEmail), 'email');
            });

        // Ordering:
        $users = $users->orderBy($this->sortBy, $this->sortDirection);

        // Pagination:
        $users = $users->paginate($this->paginate);

        return view('livewire.admin-area-users', compact('users'));
    }

    function selectModelInstance($id, $action)
    {
        $this->selectedModelInstance = $id;
        $user = User::withTrashed()->findOrFail($this->selectedModelInstance);

        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;

        $this->dispatchBrowserEventByAction($action);
    }

    function deleteModelInstance()
    {
        User::findOrFail($this->selectedModelInstance)->delete();
        $this->dispatchBrowserEvent('closeDeleteModelInstanceModal');
        $this->resetFormFields();

        session()->flash('status', 'User successfully deleted.');
        return redirect()->route('admin-area.users');
    }

    function restoreModelInstance()
    {
        User::onlyTrashed()->findOrFail($this->selectedModelInstance)->restore();
        $this->dispatchBrowserEvent('closeRestoreModelInstanceModal');
        session()->flash('status', 'User successfully restored.');

        return redirect()->route('admin-area.users');
    }

    function resetFormFields() {
        $this->name = '';
        $this->username = '';
        $this->email = '';
    }
}
