<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $predefinedPermissions = config('permission.permissions');

        foreach ($predefinedPermissions as $permissionName => $assigendRoles) {
            Permission::create(['name' => $permissionName]);
        }

        // Create roles and assign their permissions
        $predefinedRoles = config('permission.roles');
        foreach ($predefinedRoles as $roleName) {
            $role = Role::create(['name' => $roleName]);

            if ($roleName === 'super-admin') {
                continue;
            } // super-admin gets all permissions via Gate::before rule (AuthServiceProvider)

            foreach ($predefinedPermissions as $permissionName => $assigendRoles) {
                if (in_array($roleName, $assigendRoles)) {
                    $role->givePermissionTo($permissionName);
                }
            }
        }
    }
}
