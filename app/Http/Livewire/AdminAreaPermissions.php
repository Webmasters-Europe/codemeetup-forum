<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminAreaPermissions extends Component
{
    public $roles;
    public $permissions;
    public $selectedRoleId;

    public function mount(): void
    {
        $this->roles = Role::where('name', '!=', 'super-admin')->with('permissions')->get();
        $this->selectedRoleId = $this->roles->first()->id;
        $this->permissions = Permission::all();
    }

    public function render()
    {
        $actionRole = Role::find($this->selectedRoleId);

        return view('livewire.admin-area-permissions', [
            'roles' => $this->roles,
            'permissions' => $this->permissions,
            'selectedRoleId' => $this->selectedRoleId,
            'actionRole' => $actionRole, ]);
    }

    public function updateAllowedPermissions($allowedPermissions): void
    {
        $selectedRole = Role::findOrFail($this->selectedRoleId);

        $selectedRole->permissions()->sync($allowedPermissions);

        session()->flash('success', __('Permissions for role ').ucwords($selectedRole->name, '- ').__(' successfully updated.'));
    }
}
