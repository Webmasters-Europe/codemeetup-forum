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
    public $showDeletedUsers;
    public $selectedUser;

    public function render()
    {
        if ($this->showDeletedUsers) {
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
}
