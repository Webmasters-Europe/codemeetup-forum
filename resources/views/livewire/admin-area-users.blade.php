<div>
    <div class="d-flex justify-content-between align-content-center mb-2">

        <x-table-pagination/>

        <div class="custom-control custom-switch">
            <input wire:model="showDeletedUsers" type="checkbox" class="custom-control-input"
                   id="showDeletedUsers" name="showDeletedUsers"/>
            <label class="custom-control-label" for="showDeletedUsers">Show deleted Users</label>
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
                        TODO
{{--                        @if (!$showDeletedUsers)--}}
{{--                            <button wire:click="selectUser({{ $user->id }}, 'update')"--}}
{{--                                    class="btn btn-primary btn-sm">--}}
{{--                                <i class="fas fa-edit"></i>--}}
{{--                            </button>--}}
{{--                            @if ($user->id != auth()->user()->id )--}}
{{--                                <button wire:click="selectUser({{ $user->id }}, 'delete')"--}}
{{--                                        class="btn btn-danger btn-sm">--}}
{{--                                    <i class="fas fa-trash"></i>--}}
{{--                                </button>--}}
{{--                            @endif--}}
{{--                        @else--}}
{{--                            <button wire:click="selectUser({{ $user->id }}, 'restore')"--}}
{{--                                    class="btn btn-secondary btn-sm">--}}
{{--                                <i class="fas fa-trash-restore"></i>--}}
{{--                            </button>--}}
{{--                        @endif--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row mt-4">
        <div class="col-sm-6 offset-5">
            {{ $users->links() }}
        </div>
    </div>
</div>
