<div class="d-flex my-2">
    <div class="w-100" @click.away="opensearch = false" x-data="{ opensearch: false }">
        <div @click="opensearch= true">
            <input class="form-control me-2 w-100" type="search" aria-label="Search" id="search" wire:model="search"
                placeholder="{{ __('Search Posts ...') }}" autocomplete="off" />
        </div>
        @isset($posts)
        <div class="pb-2 pt-0 pl-4 mr-4"  id="search-results" x-show="opensearch">
            <div class="opensearch-inner pr-4">
                <ul>
                    @forelse($posts as $post)
                        <li class="text-justify"><a href="{{ route('posts.show', $post) }}"><h5>{{$post->title}}</h5> <article>{{$post->content}}</article></a></li>
                    @empty
                        <li>{{ __('No Posts found.') }}</li>
                    @endforelse
                </ul>
            </div>
        </div>
        @endisset
    </div>
</div>
