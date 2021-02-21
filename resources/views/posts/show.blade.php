<h1>{{ $post->title }}</h1>
<div>
    {{ $post->content }}
</div>
<div>{{ $post->user->name }}</div>
<div>{{ $post->created_at }}</div>
