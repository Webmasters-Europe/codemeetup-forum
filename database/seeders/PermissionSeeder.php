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

        // create permissions
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'update posts']);
        Permission::create(['name' => 'delete posts']);
        Permission::create(['name' => 'create post replies']);
        Permission::create(['name' => 'update post replies']);
        Permission::create(['name' => 'delete post replies']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'update categories']);
        Permission::create(['name' => 'delete categories']);

        // create roles and assign existing permissions
        $superAdminRole = Role::create(['name' => 'super-admin']); // all permissions via Gate::before rule (AuthServiceProvider)

        $moderatorRole = Role::create(['name' => 'moderator']);
        $moderatorRole->givePermissionTo('update posts');
        $moderatorRole->givePermissionTo('delete posts');
        $moderatorRole->givePermissionTo('update post replies');
        $moderatorRole->givePermissionTo('delete post replies');
        $moderatorRole->givePermissionTo('create categories');
        $moderatorRole->givePermissionTo('update categories');
        $moderatorRole->givePermissionTo('delete categories');

        $participantRole = Role::create(['name' => 'participant']);
        $participantRole->givePermissionTo('create posts');
        $participantRole->givePermissionTo('create post replies');
    }
}
