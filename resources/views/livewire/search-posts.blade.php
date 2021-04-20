<div class="relative mt-3 md:mt-0">
    <div @click.away="opensearch = false" x-data="{ opensearch: false }">
        <div @click="opensearch= true">
            <input wire:model="search" type="text" autocomplete="off"
                class="bg-gray-50 rounded-full w-80 px-4 pl-8 py-1 focus:outline-none focus:shadow-outline text-gray-600"
                placeholder="Search ...">
        </div>
        <div class="absolute top-0">
            <i class="fas fa-search absolute top-0 text-gray-500 fill-current mt-2 ml-2"></i>
        </div>
        @isset($posts)
            <div class="absolute bg-gray-400 rounded w-80 mt-4 text-sm">
                <ul>
                    @forelse($posts as $post)
                        <li class="border-gray-800 border-b m-2 pb-2">
                            <a href="{{ route('posts.show', $post) }}" class="block hover:bg-gray-600.px-3.py-3">
                                <div class="text-gray-900">{{ $post->title }}</div>
                                <div>{{ Str::limit($post->content,30) }}</div>
                            </a>
                        </li>
                    @empty
                        <li class="border-gray-800 border-b m-2">No Post found</li>
                    @endforelse
                </ul>
            </div>
            @endisset
        </div>
</div>
