
    <form wire:submit.prevent="submitForm" class="w-100">
        @csrf
        <div class="form-group p-2">
            <label for="categoryId">Category</label>
            <select wire:model="category_id" id="categoryId" name="category_id" required>
                <option value=-1 disabled selected>Choose category</option>
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

        <button type="submit" btn btn-dark btn-lg ml-2">Create post</button>
      </form>
