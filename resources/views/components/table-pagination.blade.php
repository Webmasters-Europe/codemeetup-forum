<div class="d-flex">

    <div class="d-flex align-items-center ml-4 m-2">
        <label for="paginate" class="text-nowrap mr-2 mb-0">{{ __('Per Page') }}</label>
        <select wire:model="paginate" name="paginate" id="paginate"
                class="form-select form-select-sm">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>

</div>
