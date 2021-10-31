<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Rules\AtLeastOneUserRoleRequired;
use App\Rules\OnlySuperUserMayAssignOrRevokeSuperAdminUserRole;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

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
    public $roles = [];

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

    public function selectModelInstance($id, $action): void
    {
        $this->selectedModelInstance = $id;
        $user = User::withTrashed()->findOrFail($this->selectedModelInstance);

        $this->name = $user->name;
        $this->username = $user->username;
        $this->email = $user->email;

        $this->setRolesByUser($user);

        $this->dispatchBrowserEventByAction($action);
    }

    public function deleteModelInstance(): \Illuminate\Http\RedirectResponse
    {
        User::findOrFail($this->selectedModelInstance)->delete();
        $this->dispatchBrowserEvent('closeDeleteModelInstanceModal');
        $this->resetFormFields();

        session()->flash('status', __('User successfully deleted.'));

        return redirect()->route('admin-area.users');
    }

    public function restoreModelInstance(): \Illuminate\Http\RedirectResponse
    {
        User::onlyTrashed()->findOrFail($this->selectedModelInstance)->restore();
        $this->dispatchBrowserEvent('closeRestoreModelInstanceModal');
        session()->flash('status', __('User successfully restored.'));

        return redirect()->route('admin-area.users');
    }

    public function resetFormFields(): void
    {
        $this->name = '';
        $this->username = '';
        $this->email = '';
        $this->roles = [];
    }

    public function updateRoles(): \Illuminate\Http\RedirectResponse
    {
        $user = User::findOrFail($this->selectedModelInstance);

        Validator::make(
            ['roles' => $this->roles],
            ['roles' => [new AtLeastOneUserRoleRequired(), new OnlySuperUserMayAssignOrRevokeSuperAdminUserRole($user)]]
        )->validate();

        $user->roles()->detach();
        foreach ($this->roles as $key => $value) {
            if ($value) {
                $user->assignRole($key);
            }
        }

        $this->dispatchBrowserEvent('closeUpdateModelInstanceModal');
        $this->resetFormFields();

        session()->flash('status', __('Roles of ').$user->username.__(' successfully updated.'));

        return redirect()->route('admin-area.users');
    }

    private function setRolesByUser($user): void
    {
        $this->roles = [];
        $availableRoles = Role::all();
        $userRoles = $user->roles()->pluck('id')->toArray();

        foreach ($availableRoles as $availableRole) {
            $userHasRole = in_array($availableRole->id, $userRoles);
            $this->roles[$availableRole->name] = $userHasRole;
        }
    }
}
