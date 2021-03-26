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
                        <th>Name</th>
                        <th>Description</th>
                        <th>Posts</th>
                        <th>created</th>
                        <th>updated</th>
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
                                <button class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
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
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Category Name</label>
                            <input wire:model.defer="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description <small>(optional)</small></label>
                            <input wire:model.defer="description" type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description">
                                @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
