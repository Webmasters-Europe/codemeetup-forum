<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);

        $this->middleware('verified', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->authorize('viewAny', Post::class);

        $posts = Post::all();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $category)
    {
        $this->authorize('create', Post::class);

        return view('posts.create', compact('category'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Post $post)
    {
        $this->authorize('view', Post::class);

        $replies = $post->reply()->paginate(3);

        $uploads = $post->uploads()->get();

        $images = [];
        $otherFiles = [];
        foreach ($uploads as $upload) {
            if ($this->isImage($upload->filename)) {
                array_push($images, $upload);
            } else {
                array_push($otherFiles, $upload);
            }
        }

        return view('posts.show', compact('post', 'images', 'otherFiles', 'replies'));
    }

    private function isImage($file)
    {
        $info = pathinfo($file);

        return in_array(strtolower($info['extension']),
                        ['jpg', 'jpeg', 'gif', 'png', 'bmp']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', Post::class);

        // Show the form...
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', Post::class);

        // Update the post...
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', Post::class);

        // Delete the post...
    }
}
