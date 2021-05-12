
    <form wire:submit.prevent="submitForm" class="w-50">
      @if($errors->any())
    <div class="alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
@endif
        @csrf
        <div class="form-group p-2">
            <label for="categoryId">{{ __('Category') }}</label>
            <h5>{{ $category->name }}</h5>
        </div>

        <div class="form-group p-2">
          <label for="postTitle">{{ __('Title') }}</label>
          <input wire:model="title" type="text" value="{{ old('title') }}" class="form-control" id="postTitle" name="title" placeholder="{{ __('Post title') }}" >
        </div>

        <div wire:ignore class="form-group p-2">
          <label for="postContent">{{ __('Post') }}</label>
          <x-easy-mde name="content" :options="['hideIcons' => ['image']]">
            <x-slot name="script">
              easyMDE.codemirror.on('blur', function() {
                @this.set('content', easyMDE.value())
              });
            </x-slot>
            {{ old('content', $content) }}
          </x-easy-mde>
        </div>

        <div  wire:ignore 
              x-data 
              x-init="
                FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);
                FilePond.setOptions({
                  allowMultiple: 'true',
                  allowFileTypeValidation: 'true',
                  acceptedFileTypes: ['image/*', 'application/pdf'],
                  server: {
                      process:(fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        @this.upload('files', file, load, error, progress)
                      },
                      revert: (filename, load) => {
                        @this.removeUpload('files', filename, load)
                      },
                    },
                  });
                FilePond.create($refs.input);
              "
        >
              <input wire:model="files" type="files" x-ref="input" multiple>
        </div>

        <button type="submit" class="btn btn-lg ml-2 mb-4" style="background-color: {{ config('app.settings.primary_color') }}; color: {{ config('app.settings.button_text_color') }};">{{ __('Create Post') }}</button>
      </form>
