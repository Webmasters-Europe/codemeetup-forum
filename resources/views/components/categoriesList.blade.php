@if (count($categories) === 0)
    <div class="sm:text-xl text-xl text-white font-medium title-font">
        No categories found in this forum. Please contact Administrator.
    </div>
@endif
<div class="bg-white shadow overflow-hidden sm:rounded-md">
<ul class="divide-y divide-gray-200">
    @foreach ($categories as $category)
        <li>
            <a href="{{route('category.show', $category)}}" class="block hover:bg-gray-50">
                <div class="flex items-center px-4 py-4 sm:px-6">
                    <div class="min-w-0 flex-1 flex items-center">
                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                            <div>
                                <p class="text-md font-medium text-gray-900 truncate">
                                    {{ $category->name }}</p>
                                <p class="mt-2 flex items-center text-sm text-gray-500">
                                    <span class="truncate">{{ $category->description }}</span>
                                </p>
                            </div>
                            <div class="hidden md:block">
                                <div>
                                    <p class="text-sm text-gray-900">
                                        created at {{ $category->created_at }}
                                    </p>
                                    <p class="mt-2 flex items-center text-sm text-gray-500">
                                        <!-- Heroicon name: document-text -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{$category->posts_count}} Posts in this category
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </li>
    @endforeach
{{ $categories->links() }}
</ul>
</div>