{{-- <div class="d-flex mx-4 my-2">
    <div @click.away="opensearch = false" x-data="{ opensearch: false }">
        <div @click="opensearch= true">
            <input class="form-control me-2" type="search" aria-label="Search" id="search" wire:model="search"
                placeholder="Search Posts ..." />
        </div>
        @isset($posts)
        <div x-show="opensearch">
            <ul>
                @forelse($posts as $post)
                <li>
                    <a href="{{ route('posts.show', $post)}}"> {{$post->title}} {{$post->content->limit(30)}}</a>
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
</div> --}}
TEST
