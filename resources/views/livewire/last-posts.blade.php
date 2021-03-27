<div>
    <div class="last-entries mt-5">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Last entries</span>
            {{-- <span class="badge badge-secondary badge-pill">3</span> --}}
        </h4>
        <ul class="list-group mb-3">
            @foreach ($posts as $post)
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <a href="{{ route('posts.show', $post)}}"><h6 class="my-0">{{ $post->title }}</h6></a>
                        <small class="text-muted">{{ $post->category->name }}</small>
                        <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
