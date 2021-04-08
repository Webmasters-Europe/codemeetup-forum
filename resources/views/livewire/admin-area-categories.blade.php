<div>
    <div>
        <div class="d-flex justify-content-between align-content-center mb-2">
            <x-table-pagination />
            <div class="custom-control custom-switch">
                <input wire:model="showDeletedCategories" wire:click="resetPaginatorPage" type="checkbox"
                    class="custom-control-input" id="showDeletedCategories" name="showDeletedCategories" />
                <label class="custom-control-label" for="showDeletedCategories">Show deleted Categories</label>
            </div>
            <div>
                {{-- Add new Category Modal --}}
                <span x-data="{ showAddModal: @entangle('showAddModal') }">
                    <button x-on:click="$wire.showCategoryForm()" class="btn btn-success btn-sm"><i
                            class="fas fa-plus-circle mr-2"></i>Add new Category
                    </button>
                    <div x-show="showAddModal" @click.away="showAddModal = false" x-cloak>
                        <div class="modal fade-in" style="display:block;" x-cloak>
                            <div class="modal-dialog">
                                <form wire:submit.prevent="addNewCategory">
                                    @csrf
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                Add new Category
                                            </h5>
                                            <button type="button" class="close" x-on:click="showAddModal = false">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @include('components.categoryForm')
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                x-on:click="showAddModal = false">Cancel</button>
                                            <button type="submit" class="btn btn-success">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </span>
            </div>
            <div class=" col-md-4">
                <input wire:model="search" type="search" class="form-control"
                    placeholder="Search in name and description">
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th wire:click="sortBy('name')" style="cursor: pointer;">
                            Name @include('components.sort_icon',['field' => 'name'])

                        </th>
                        <th wire:click="sortBy('description')" style="cursor: pointer;">
                            Description @include('components.sort_icon',['field' => 'description'])
                        </th>
                        <th wire:click="sortBy('posts_count')" style="cursor: pointer;">Posts
                            @include('components.sort_icon',['field' => 'posts_count'])</th>
                        <th wire:click="sortBy('created_at')" style="cursor: pointer;">created
                            @include('components.sort_icon',['field' => 'created_at'])</th>
                        <th wire:click="sortBy('updated_at')" style="cursor: pointer;">updated
                            @include('components.sort_icon',['field' => 'updated_at'])</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <th> <input wire:model="searchName" type="search" class="form-control"
                                placeholder="Search Name"></th>
                        <th> <input wire:model="searchDescription" type="search" class="form-control"
                                placeholder="Search Description"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                @if (!$showDeletedCategories)
                                    {{ $category->posts_count }}
                                @else
                                    {{ $category->posts_trashed_count }}
                                @endif
                            </td>
                            <td>{{ $category->created_at->format('d.m.Y H:i:s') }}</td>
                            <td>{{ $category->updated_at->format('d.m.Y H:i:s') }}</td>
                            <td>
                                @if (!$showDeletedCategories)
                                    {{-- Edit Category Modal --}}
                                    <span x-data="{ showEditModal: @entangle('showEditModal') }">
                                        <button x-on:click="$wire.selectCategory({{ $category->id }}, 'edit')"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <div x-show="showEditModal" x-cloak>
                                            <div class="modal fade-in" style="display:block;" x-cloak>
                                                <div class="modal-dialog">
                                                    <form wire:submit.prevent="update">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                    Edit Category
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    x-on:click="showEditModal = false">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            @include('components.categoryForm')
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    x-on:click="showEditModal = false">Cancel</button>
                                                                <button type="submit" class="btn btn-success">
                                                                    Save
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </span> 
                                    {{-- Delete Category Modal --}}
                                    <span x-data="{ showDeleteModal: @entangle('showDeleteModal') }">
                                        <button x-on:click="$wire.selectCategory({{ $category->id }}, 'delete')"
                                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i>
                                        </button>
                                        <div x-show="showDeleteModal" @click.away="showDeleteModal = false" x-cloak>
                                            <div class="modal fade-in" style="display:block;" x-cloak>
                                                <div class="modal-dialog">
                                                    <form wire:submit.prevent="delete">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                    Delete this Category
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    x-on:click="showDeleteModal = false">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Do you really want to delete this category:
                                                                <h5>{{ $name }}</h5>
                                                                <p>Description: <br> {{ $description }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    x-on:click="showDeleteModal = false">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">
                                                                    Yes, Delete
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                @else
                                    <!-- Restore Cagegory Modal -->
                                    <span x-data="{ showRestoreModal: @entangle('showRestoreModal') }">
                                        <button x-on:click="$wire.selectCategory({{ $category->id }}, 'restore')"
                                            class="btn btn-secondary btn-sm"><i class="fas fa-trash-restore"></i>
                                        </button>
                                        <div x-show="showRestoreModal" @click.away="showRestoreModal = false" x-cloak>
                                            <div class="modal fade-in" style="display:block;" x-cloak>
                                                <div class="modal-dialog">
                                                    <form wire:submit.prevent="restore">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                    Restore this Category
                                                                </h5>
                                                                <button type="button" class="close"
                                                                    x-on:click="showRestoreModal = false">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Do you really want to restore this category:
                                                                <h5>{{ $name }}</h5>
                                                                <p>Description: <br> {{ $description }}</p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    x-on:click="showRestoreModal = false">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">
                                                                    Yes, Restore
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="row mt-4 justify-content-center">
            {{ $categories->links() }}
            <span class="ml-4">
                {{ $categories->firstItem() }} - {{ $categories->lastItem() }} from {{ $categories->total() }} results
            </span>
        </div>
    </div>
</div>