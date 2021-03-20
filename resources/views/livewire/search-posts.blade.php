<div class="d-flex my-2">
    <div class="w-100" @click.away="opensearch = false" x-data="{ opensearch: false }">
        <div @click="opensearch= true">
            <input class="form-control me-2 w-100" type="search" aria-label="Search" id="search" wire:model="search"
                placeholder="Search Posts ..." />
        </div>
        @isset($posts)
        <div x-show="opensearch">
            <ul>
                @forelse($posts as $post)
                <li>
                    <a href="{{ route('posts.show', $post)}}"> {{$post->title}} {{$post->content}}</a>
                </li>
                @empty
                <li>
                    No Post found
                </li>
                @endforelse
            </ul>
        </div>
        @endisset
    </div>
</div>
