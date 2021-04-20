<div>
    <div class="p-5 bg-indigo-100 rounded-lg">
        <h4>Last Post-Entries</h4>
        @if($posts->isEmpty())
            <small>No posts found ...</small>
        @endif
        <ul>
            @foreach ($posts as $post)
                <div class="max-w-md py-1 px-1 bg-white shadow-lg rounded-lg my-5">
                    <div>
                        <h4 class="text-gray-800 text-lg font-semibold">{{ $post->category->name }}</h4>
                        <p class="mt-2 text-gray-600">
                            <a href="{{ route('posts.show', $post)}}">
                                    <i class="fas fa-link mr-2"></i>{{ Str::limit($post->title, 50) }}
                            </a>
                        </p>
                    </div>
                    <div class="flex justify-end mt-4">
                        <small>
                            by
                            @if ($post->user->trashed())
                                a deleted user
                            @else
                                <a href=" {{ route('users.show', $post->user) }}" class="text-md font-medium text-indigo-500">{{$post->user->username}}</a>
                            @endif
                        </small>
                    </div>
                    <div class="flex justify-end mt-2">
                        <small>{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            @endforeach
        </ul>
    </div>
</div>
