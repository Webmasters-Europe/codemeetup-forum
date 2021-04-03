<div>
    <div class="d-flex justify-content-between align-content-center mb-2">

        <x-table-pagination/>

        <div class="custom-control custom-switch">
            <input wire:model="showDeletedElements" type="checkbox" class="custom-control-input"
                   id="showDeletedElements" name="showDeletedElements"/>
            <label class="custom-control-label" for="showDeletedElements">Show deleted Users</label>
        </div>
        <div class=" col-md-4">
            <input wire:model="globalSearch" type="search" class="form-control"
                   placeholder="Search in name, username and email">
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover">
            <tbody>
            <tr>
                <th wire:click="sortBy('name')" style="cursor: pointer;">
                    Name @include('components.sort_icon',['field' => 'name'])
                </th>
                <th wire:click="sortBy('username')" style="cursor: pointer;">
                    Username @include('components.sort_icon',['field' => 'username'])
                </th>
                <th wire:click="sortBy('email')" style="cursor: pointer;">
                    Email @include('components.sort_icon',['field' => 'email'])
                </th>
                <th>
                    Roles
                </th>
                <th wire:click="sortBy('created_at')" style="cursor: pointer;">
                    User since @include('components.sort_icon',['field' => 'created_at'])
                </th>
                <th wire:click="sortBy('posts_count')" style="cursor: pointer;">
                    # Posts @include('components.sort_icon',['field' => 'posts_written_count'])
                </th>
                <th wire:click="sortBy('post_replies_count')" style="cursor: pointer;">
                    # Replies @include('components.sort_icon',['field' => 'replies_written_count'])
                </th>
                <th>Action</th>
            </tr>
            <tr>
                <th>
                    <input wire:model="searchName" type="search" class="form-control" placeholder="Search Name">
                </th>
                <th>
                    <input wire:model="searchUsername" type="search" class="form-control" placeholder="Search Username">
                </th>
                <th>
                    <input wire:model="searchEmail" type="search" class="form-control" placeholder="Search Email">
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
                        {{ $user->getRoleNames()->implode(', ') }}
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
{{--                            <button wire:click="selectModelInstance({{ $user->id }}, 'update')"--}}
{{--                                    class="btn btn-primary btn-sm">--}}
{{--                                <i class="fas fa-edit"></i>--}}
{{--                            </button>--}}
                            @if ($user->id != auth()->user()->id )
                                <button wire:click="selectModelInstance({{ $user->id }}, 'delete')"
                                        class="btn btn-danger btn-sm">
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
        <div class="col-sm-6 offset-5">
            {{ $users->firstItem()}} - {{ $users->lastItem() }} from {{ $users->total() }} results
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
                        <h5 class="modal-title" id="deleteModelInstanceLabel">Delete this User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4>Do you really want to delete this User?</h4>
                        <p>Name: {{ $name }}</p>
                        <p>Username: {{ $username }}</p>
                        <p>Email: {{ $email }}</p>
                        <p>
                            The posts and replies of this user will not be deleted but they will be shown in an anonymous way.
                            The user will not be able to login any more.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
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
                        <h5 class="modal-title" id="restoreModelInstanceModalLabel">Restore this User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4>Do you really want to restore this User?</h4>
                        <p>Name: {{ $name }}</p>
                        <p>Username: {{ $username }}</p>
                        <p>Email: {{ $email }}</p>
                        <p>
                            The posts and replies of this user will not be anonymized any longer
                            and the user will be able to login again.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Yes, Restore</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
