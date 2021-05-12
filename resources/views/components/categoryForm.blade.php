<div class="modal-body">
    <div class="form-group">
        <label for="name">{{ __('Category Name') }}</label>
        <input wire:model.defer="name" type="text"
            class="form-control @error('name') is-invalid @enderror" name="name">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <div class="form-group">
        <label for="description">{{ __('Description') }} <small>(optional)</small></label>
        <input wire:model.defer="description" type="text"
            class="form-control @error('description') is-invalid @enderror"
            name="description">
        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>