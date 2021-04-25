<div>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-4">
        Administrate the permissions of role
        <select wire:model="selectedRoleId" id="selectedRoleId">
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ ucwords($role->name, '-') }}</option>
            @endforeach
        </select>
    </div>

    <div class="mt-4 mb-4">
        <h4>Permissions of role <strong>{{ ucwords($actionRole->name, '-') }}</strong></h4>

        <div style="display: flex">

            <div class="bg-primary p-3 w-25">
                <p><strong>Allowed Actions</strong></p>
                <x-laravel-blade-sortable::sortable group="people" :allow-sort="false" animation="500" class="h-100" wire:onSortOrderChange="updateAllowedPermissions">
                    @foreach ($actionRole->permissions as $permission)
                        <x-laravel-blade-sortable::sortable-item sort-key="{{ $permission->id }}" style="cursor: grab">
                            {{ ucwords($permission->name, " -") }}
                        </x-laravel-blade-sortable::sortable-item>
                    @endforeach
                </x-laravel-blade-sortable::sortable>
            </div>

            <div class="bg-secondary p-3 w-25">
                <p><strong>Disallowed Actions</strong></p>
                <x-laravel-blade-sortable::sortable group="people" :allow-sort="false" animation="500" class="h-100">
                    @foreach ($permissions as $permission)
                        @if (!$actionRole->hasPermissionTo($permission))
                            <x-laravel-blade-sortable::sortable-item sort-key="{{ $permission->id }}" style="cursor: grab">
                                {{ ucwords($permission->name, " -") }}
                            </x-laravel-blade-sortable::sortable-item>
                        @endif
                    @endforeach
                </x-laravel-blade-sortable::sortable>
            </div>
        </div>
    </div>
</div>
