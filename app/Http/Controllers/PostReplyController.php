<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostReplyRequest;
use App\Models\Post;
use App\Models\PostReply;

class PostReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function create(Post $post)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function store(PostReplyRequest $request, Post $post, PostReply $reply = null)
    {
        $postReply = new PostReply();
        $postReply->content = $request->content;
        $postReply->user_id = auth()->user()->id;
        $postReply->post_id = $post->id;

        if (!$reply) {
            $post->reply()->save($postReply);
        } else {
            $reply->reply()->save($postReply);
        }

        return redirect()->back()->withStatus('Postreply successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\PostReply  $postReply
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, PostReply $postReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\PostReply  $postReply
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post, PostReply $postReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @param  \App\Models\PostReply  $postReply
     * @return \Illuminate\Http\Response
     */
    public function update(PostReplyRequest $request, Post $post, PostReply $postReply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @param  \App\Models\PostReply  $postReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post, PostReply $postReply)
    {
        //
    }
}
