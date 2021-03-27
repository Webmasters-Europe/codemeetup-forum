<div class="d-flex my-2">
    <div class="w-100" @click.away="opensearch = false" x-data="{ opensearch: false }">
        <div @click="opensearch= true">
            <input class="form-control me-2 w-100" type="search" aria-label="Search" id="search" wire:model="search"
                placeholder="Search Posts ..." list="search-results" autocomplete="off" onchange="redirectToPost(this.value)" />
        </div>
        @isset($posts)
        <div x-show="opensearch">
            <datalist id="search-results">
                @forelse($posts as $post)
                <option value="{{ route('posts.show', $post) }}" >
                  {{$post->title}} {{$post->content}}
                  </option>
                @empty
                <option value="No Post found">
                @endforelse
            </datalist>
        </div>
        @endisset
    </div>
</div>
