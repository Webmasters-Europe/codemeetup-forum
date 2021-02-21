@foreach($posts as $post)
<ul>
    <li><a href="{{ route('posts.show', $post)}}">{{ $post->title}}</a></li>
</ul>
@endforeach