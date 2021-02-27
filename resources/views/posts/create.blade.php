<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="content" cols="30" rows="10" placeholder="Content"></textarea>
    <button type="submit">Save</button>
</form>