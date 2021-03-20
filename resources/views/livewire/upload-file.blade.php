<div>
    <div class="form-group p-2">
        <div
            x-data="{ isUploading: false, progress: 0 }"
            x-on:livewire-upload-start="isUploading = true"
            x-on:livewire-upload-finish="isUploading = false"
            x-on:livewire-upload-error="isUploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
         >
            <div x-show="isUploading" class="w-100 h-5">
                <progress max="100" x-bind:value="progress" class="w-100"></progress>
            </div>
            @error('file')
                <span class="error">{{ $message }}</span>            
            @enderror
            @if ($files)
                @foreach ($files as $file)
                    <img src="{{ $file->temporaryUrl() }}" width="100">
                @endforeach
            @endif
            <div class="border border-secondary rounded w-100 p-3 h-50 d-inline-block text-center" @click="$refs.fileInput.click()">Click here to upload Files</div>
            <input x-ref="fileInput" type="file" multiple wire:model="files" class="invisible" />
        </div>
    </div>
</div>
