<div>
    <div>
        <div class="d-flex justify-content-between align-content-center mb-2">
            <div class="d-flex">
                <div>
                    <div class="d-flex align-items-center ml-4">
                        <label for="paginate" class="text-nowrap mr-2 mb-0">Per Page</label>
                        <select wire:model="paginate" name="paginate" id="paginate"
                            class="form-control form-control-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="custom-control custom-switch">
                <input wire:model="showDeletedCategories" type="checkbox" class="custom-control-input"
                    id="showDeletedCategories" name="showDeletedCategories" />
                <label class="custom-control-label" for="showDeletedCategories">Show deleted Categories</label>
            </div>
            <div>
                <button wire:click.prevent="showCategoryForm" class="btn btn-sm btn-success"><i
                        class="fas fa-plus-circle mr-2"></i>Add new Category</button>
            </div>
            <div class=" col-md-4">
                <input wire:model="search" type="search" class="form-control" placeholder="Search by name, description">
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th wire:click="sortBy('name')" style="cursor: pointer;">Name @include('components.sort_icon',['field' => 'name'])</th>
                        <th wire:click="sortBy('description')" style="cursor: pointer;">Description @include('components.sort_icon',['field' => 'description'])</th>
                        <th wire:click="sortBy('posts_count')" style="cursor: pointer;">Posts @include('components.sort_icon',['field' => 'posts_count'])</th>
                        <th wire:click="sortBy('created_at')" style="cursor: pointer;">created @include('components.sort_icon',['field' => 'created_at'])</th>
                        <th wire:click="sortBy('updated_at')" style="cursor: pointer;">updated @include('components.sort_icon',['field' => 'updated_at'])</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>{{ $category->posts_count }}</td>
                            <td>{{ $category->created_at->format('d.m.Y H:i:s') }}</td>
                            <td>{{ $category->updated_at->format('d.m.Y H:i:s') }}</td>
                            <td>
                                @if (!$showDeletedCategories)
                                    <button wire:click="selectCategory({{ $category->id }}, 'update')"
                                        class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button wire:click="selectCategory({{ $category->id }}, 'delete')"
                                        class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @else
                                    <button wire:click="selectCategory({{ $category->id }}, 'restore')"
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
                {{ $categories->links() }}
            </div>
        </div>
    </div>

    <!-- Modal for Add new Category-->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="addNewCategory">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel">Add new Category</h5>
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

    <!-- Modal for Update Category-->
    <div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="update">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateCategoryModalLabel">Update Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @include('components.categoryForm')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Delete Category-->
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="delete">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCategoryModalLabel">Delete this Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Do you really want to delete this category:
                        <h5>{{ $name }}</h5>
                        <p>Description: <br> {{ $description }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Restore Category-->
    <div class="modal fade" id="restoreCategoryModal" tabindex="-1" aria-labelledby="restoreCategoryModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="restore">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="restoreCategoryModalLabel">Restore this Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Do you really want to restore this category:
                        <h5>{{ $name }}</h5>
                        <p>Description: <br> {{ $description }}</p>
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