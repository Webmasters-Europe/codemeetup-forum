<div>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-4">
        {{ __('Administrate the permissions of role') }}
        <select wire:model="selectedRoleId" id="selectedRoleId">
            @foreach($roles as $role)
                <option value="{{ $role->id }}">{{ ucwords($role->name, '-') }}</option>
            @endforeach
        </select>
    </div>

    <div class="mt-4 mb-4">
        <h4>{{ __('Permissions of role') }} <strong>{{ ucwords($actionRole->name, '-') }}</strong></h4>

        <div class="permissions d-flex h-100">

            <div class="allowed-actions p-3 w-50">
                <h2 class="text-white text-center">{{ __('Allowed Actions') }}</h2>
                <x-laravel-blade-sortable::sortable group="people" :allow-sort="false" animation="500" class="d-flex flex-row flex-wrap h-90 align-items-center align-content-flex-start" wire:onSortOrderChange="updateAllowedPermissions">
                    @foreach ($actionRole->permissions as $permission)
                        <x-laravel-blade-sortable::sortable-item sort-key="{{ $permission->id }}" style="cursor: grab" class="action m-1 px-2 py-1">
                            {{ ucwords($permission->name, " -") }}
                        </x-laravel-blade-sortable::sortable-item>
                    @endforeach
                </x-laravel-blade-sortable::sortable>
            </div>

            <div class="disallowed-actions p-3 w-50">
                <h2 class="text-center">{{ __('Disallowed Actions') }}</h2>
                <x-laravel-blade-sortable::sortable group="people" :allow-sort="false" animation="500" class="d-flex flex-row flex-wrap h-90 align-items-center align-content-flex-start">
                    @foreach ($permissions as $permission)
                        @if (!$actionRole->hasPermissionTo($permission))
                            <x-laravel-blade-sortable::sortable-item sort-key="{{ $permission->id }}" style="cursor: grab" class="action m-1 px-2 py-1">
                                {{ ucwords($permission->name, " -") }}
                            </x-laravel-blade-sortable::sortable-item>
                        @endif
                    @endforeach
                </x-laravel-blade-sortable::sortable>
            </div>
        </div>
    </div>
</div>
