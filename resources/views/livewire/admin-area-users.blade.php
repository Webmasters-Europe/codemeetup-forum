<div>
    <div class="d-flex flex-wrap justify-content-start align-items-center mb-2">

        <x-table-pagination/>

        <div class="custom-control custom-switch m-2">
            <input wire:model="showDeletedElements" wire:click="resetPaginatorPage" type="checkbox" class="custom-control-input"
                   id="showDeletedElements" name="showDeletedElements"/>
            <label class="custom-control-label" for="showDeletedElements">{{ __('Show deleted Users') }}</label>
        </div>
        <div class="m-2">
            <input wire:model="globalSearch" type="search" class="form-control"
                   placeholder="{{ __('Search in name, username, email') }}">
        </div>
    </div>
    <div class="card-body table-responsive-md p-0">
        <table class="table table-hover">
            <tbody>
            <tr>
                <th wire:click="sortBy('name')" style="cursor: pointer;">
                    {{ __('Name') }} @include('components.sort_icon',['field' => 'name'])
                </th>
                <th wire:click="sortBy('username')" style="cursor: pointer;">
                    {{ __('Username') }} @include('components.sort_icon',['field' => 'username'])
                </th>
                <th wire:click="sortBy('email')" style="cursor: pointer;">
                    {{ __('Email') }} @include('components.sort_icon',['field' => 'email'])
                </th>
                <th class="">
                    {{ __('Roles') }}
                </th>
                <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                    {{ __('User since') }} @include('components.sort_icon',['field' => 'created_at'])
                </th>
                <th wire:click="sortBy('posts_count')" style="cursor: pointer;">
                    # {{ __('Posts') }} @include('components.sort_icon',['field' => 'posts_written_count'])
                </th>
                <th wire:click="sortBy('post_replies_count')" style="cursor: pointer;">
                    # {{ __('Replies') }} @include('components.sort_icon',['field' => 'replies_written_count'])
                </th>
                <th>{{ __('Action') }}</th>
            </tr>
            <tr>
                <th>
                    <input wire:model="searchName" type="search" class="form-control" placeholder="{{ __('Search Name') }}">
                </th>
                <th>
                    <input wire:model="searchUsername" type="search" class="form-control" placeholder="{{ __('Search Username') }}">
                </th>
                <th>
                    <input wire:model="searchEmail" type="search" class="form-control" placeholder="{{ __('Search Email') }}">
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        <ul>
                            @foreach($user->getRoleNames() as $roleName)
                                <li>{{ ucwords($roleName, '-') }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $user->created_at->format('d.m.Y H:i:s') }}</td>
                    <td>
                        {{ $user->posts_count }}
                    </td>
                    <td>
                        {{ $user->post_replies_count }}
                    </td>
                    <td>
                        @if (!$showDeletedElements)
                            <button wire:click="selectModelInstance({{ $user->id }}, 'update')"
                                    class="btn btn-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                            @if ($user->id != auth()->user()->id )
                                <button wire:click="selectModelInstance({{ $user->id }}, 'delete')"
                                        class="btn btn-secondary btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        @else
                            <button wire:click="selectModelInstance({{ $user->id }}, 'restore')"
                                    class="btn btn-secondary btn-sm">
                                <i class="fas fa-trash-restore"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-4">
        <div class="col-sm-6">
            {{ $users->firstItem()}} - {{ $users->lastItem() }} {{ __('from') }} {{ $users->total() }}
            {{ $users->links() }}
        </div>
    </div>

    <!-- Modal for Delete User -->
    <div class="modal fade" id="deleteModelInstanceModal" tabindex="-1" aria-labelledby="deleteModelInstanceModalLabel"
         aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="deleteModelInstance">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModelInstanceLabel">{{ __('Delete this User') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4>{{ __('Do you really want to delete this User?') }}</h4>
                        <p>{{ __('Name') }}: {{ $name }}</p>
                        <p>{{ __('Username') }}: {{ $username }}</p>
                        <p>{{ __('Email') }}: {{ $email }}</p>
                        <p>
                            {{ __('The posts and replies of this user will not be deleted but they will be shown in an anonymous way. The user will not be able to login any more.') }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Yes, Delete') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Restore User -->
    <div class="modal fade" id="restoreModelInstanceModal" tabindex="-1" aria-labelledby="restoreModelInstanceModalLabel"
         aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="restoreModelInstance">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="restoreModelInstanceModalLabel">{{ __('Restore this User') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4>{{ __('Do you really want to restore this User?') }}</h4>
                        <p>{{ __('Name') }}: {{ $name }}</p>
                        <p>{{ __('Username') }}: {{ $username }}</p>
                        <p>{{ __('Email') }}: {{ $email }}</p>
                        <p>
                            {{ __('The posts and replies of this user will not be anonymized any longer and the user will be able to login again.') }}
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Yes, Restore') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Edit User -->
    <div class="modal fade" id="updateModelInstanceModal" tabindex="-1" aria-labelledby="updateModelInstanceModalLabel"
         aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="updateRoles">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModelInstanceModalLabel">{{ __('Edit user roles of') }} {{ $username }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            @foreach($roles as $key=>$option)
                                <div>
                                    <label class="inline-flex items-center">
                                        <input wire:model.defer="roles.{{ $key }}" value="1" type="checkbox"
                                              @if(!auth()->user()->can('assign super-admin role') && $key === 'super-admin') disabled @endif>
                                        <span class="ml-2">{{ ucwords($key, '-') }}</span>
                                        @if(!auth()->user()->can('assign super-admin role') && $key === 'super-admin')
                                            <span class="small">[You are not allowed to assign or revoke this role.]</span>
                                        @endif
                                    </label>
                                </div>
                            @endforeach

                            @if($errors->has('roles'))
                            <div class="text-danger">
                                {{ $errors->first('roles') }}
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
