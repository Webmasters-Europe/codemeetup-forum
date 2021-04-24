<div>
    <div>
        <div class="d-flex justify-content-between align-content-center mb-2">

            <x-table-pagination/>

            <div class="custom-control custom-switch">
                <input wire:model="showDeletedPosts" wire:click="resetPaginatorPage" type="checkbox" class="custom-control-input"
                    id="showDeletedPosts" name="showDeletedPosts" />
                <label class="custom-control-label" for="showDeletedPosts">Show deleted Posts</label>
            </div>
            <div>
                <button wire:click.prevent="showPostForm" class="btn btn-sm btn-success">
                    <i class="fas fa-plus-circle mr-2"></i>Add new Post
                </button>
            </div>
            <div class=" col-md-4">
                <input wire:model="search" type="search" class="form-control" placeholder="Search in name and description">
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th>Id</th>
                        <th>Title @include('components.sort_icon',['field' => 'description'])</th>
                        <th>by User</th>
                        <th>Replies</th>
                        <th wire:click="sortBy('created_at')" style="cursor: pointer;">created @include('components.sort_icon',['field' => 'created_at'])</th>
                        <th wire:click="sortBy('updated_at')" style="cursor: pointer;">updated @include('components.sort_icon',['field' => 'updated_at'])</th>
                        <th>Action</th>
                    </tr>
                    
                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->user->name}}</td>
                            <td>{{ $post->replyCount}}</td>
                            <td>{{ $post->created_at->format('d.m.Y H:i:s') }}</td>
                            <td>{{ $post->updated_at->format('d.m.Y H:i:s') }}</td>
                            <td>
                                @if (!$showDeletedPosts)
                                    <button wire:click="selectPost({{ $post->id }}, 'update')"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="selectPost({{ $post->id }}, 'delete')"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @else
                                    <button wire:click="selectPost({{ $post->id }}, 'restore')"
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
                {{ $posts->firstItem()}} - {{ $posts->lastItem() }} from {{ $posts->total() }} results
                {{ $posts->links() }}
            </div>
        </div>
    </div>


<!-- Modal for Delete Post -->
<div class="modal fade" id="deleteModelInstanceModal" tabindex="-1" aria-labelledby="deleteModelInstanceModalLabel"
aria-hidden="true" wire:ignore.self>
<div class="modal-dialog">
    <form wire:submit.prevent="delete">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModelInstanceModalLabel">Delete this Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Do you really want to delete this Post:
                <h5>Title: {{ $title }} ({{$replyCount}} Replies)</h5>
                <p>by User:<br> {{ $userName }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
            </div>
        </div>
    </form>
</div>
</div>

<!-- Modal for Restore Post-->
<div class="modal fade" id="restoreModelInstanceModal" tabindex="-1" aria-labelledby="restoreModelInstanceModalLabel"
aria-hidden="true" wire:ignore.self>
<div class="modal-dialog">
    <form wire:submit.prevent="restore">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreModelInstanceModalLabel">Restore this Post and all including replies.</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Do you really want to restore this Post:
                <h5>{{ $post->title }}</h5>
                <p>by User: <br> {{ $post->user->name }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Yes, Restore</button>
            </div>
        </div>
    </form>
</div>
</div>
    <!-- Modal for Add new Category-->
    <div class="modal fade" id="addModelInstanceModal" tabindex="-1" aria-labelledby="addModelInstanceModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="addNewCategory">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModelInstanceModalLabel">Add new Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @include('components.categoryForm')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    

</div>
 