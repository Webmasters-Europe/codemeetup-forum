<div>
    <div>
        <div class="d-flex justify-content-between align-content-center mb-2">

            <x-table-pagination/>

            <div class="custom-control custom-switch">
                <input wire:model="showDeletedCategories" wire:click="resetPaginatorPage" type="checkbox" class="custom-control-input"
                    id="showDeletedCategories" name="showDeletedCategories" />
                <label class="custom-control-label" for="showDeletedCategories">{{ __('Show deleted Categories') }}</label>
            </div>
            <div>
                <button wire:click.prevent="showCategoryForm" class="btn btn-sm" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};><i
                        class="fas fa-plus-circle mr-2"></i>{{ __('Add new Category') }}</button>
            </div>
            <div class=" col-md-4">
                <input wire:model="search" type="search" class="form-control" placeholder="{{ __('Search in name and description') }}">
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                    <tr>
                        <th wire:click="sortBy('name')" style="cursor: pointer;">
                            {{ __('Name') }} @include('components.sort_icon',['field' => 'name'])

                        </th>
                        <th wire:click="sortBy('description')" style="cursor: pointer;">
                            {{ __('Description') }} @include('components.sort_icon',['field' => 'description'])
                        </th>
                        <th wire:click="sortBy('posts_count')" style="cursor: pointer;">{{ __('Posts') }} @include('components.sort_icon',['field' => 'posts_count'])</th>
                        <th wire:click="sortBy('created_at')" style="cursor: pointer;">{{ __('created') }} @include('components.sort_icon',['field' => 'created_at'])</th>
                        <th wire:click="sortBy('updated_at')" style="cursor: pointer;">{{ __('updated') }} @include('components.sort_icon',['field' => 'updated_at'])</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                    <tr>
                        <th> <input wire:model="searchName" type="search" class="form-control" placeholder="{{ __('Search Name') }}"></th>
                        <th> <input wire:model="searchDescription" type="search" class="form-control" placeholder="{{ __('Search Description') }}"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>@if (!$showDeletedCategories)
                                    {{ $category->posts_count }}
                                @else
                                    {{ $category->posts_trashed_count }}
                                @endif
                            </td>
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
                {{ $categories->firstItem()}} - {{ $categories->lastItem() }} {{ _('from') }} {{ $categories->total() }}
                {{ $categories->links() }}
            </div>
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
                        <h5 class="modal-title" id="addModelInstanceModalLabel">{{ __('Add new Category') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @include('components.categoryForm')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Update Category-->
    <div class="modal fade" id="updateModelInstanceModal" tabindex="-1" aria-labelledby="updateModelInstanceModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="update">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModelInstanceModalLabel">{{ __('Update Category') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @include('components.categoryForm')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Delete Category-->
    <div class="modal fade" id="deleteModelInstanceModal" tabindex="-1" aria-labelledby="deleteModelInstanceModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="delete">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModelInstanceModalLabel">{{ __('Delete this Category') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ __('Do you really want to delete this category') }}
                        <h5>{{ $name }}</h5>
                        <p>{{ __('Description') }}: <br> {{ $description }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Yes, Delete') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Restore Category-->
    <div class="modal fade" id="restoreModelInstanceModal" tabindex="-1" aria-labelledby="restoreModelInstanceModalLabel"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <form wire:submit.prevent="restore">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="restoreModelInstanceModalLabel">{{ __('Restore this Category') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ __('Do you really want to restore this category') }}
                        <h5>{{ $name }}</h5>
                        <p>{{ __('Description') }}: <br> {{ $description }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('Yes, Restore') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
