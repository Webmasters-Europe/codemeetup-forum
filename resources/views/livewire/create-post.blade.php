
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
            <label for="categoryId">Category</label>
            <select wire:model="category_id" id="categoryId" name="category_id">
                <option value="" disabled selected>Choose category</option>
                @foreach($categories as $category)
                    <option {{ old('category_id') == $category->id ? 'selected' : '' }} value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group p-2">
          <label for="postTitle">Title</label>
          <input wire:model="title" type="text" value="{{ old('title') }}" class="form-control" id="postTitle" name="title" placeholder="Post title" >
        </div>

        <div wire:ignore class="form-group p-2">
          <label for="postContent">Post</label>
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

        <button type="submit" class="btn btn-dark btn-lg ml-2 mb-4">Create post</button>
      </form>
