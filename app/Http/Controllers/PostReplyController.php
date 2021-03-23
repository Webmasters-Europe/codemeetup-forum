<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostReplyRequest;
use App\Mail\ReplyToPost;
use App\Models\Post;
use App\Models\PostReply;
use App\Notifications\ReplyNotification;
use Illuminate\Support\Facades\Mail;

class PostReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);

        $this->middleware('verified', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post)
    {
        $this->authorize('viewAny', PostReply::class);

        // List post replies...
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(PostReplyRequest $request, Post $post, PostReply $postReply = null)
    {
        $this->authorize('create', PostReply::class);

        $newPostReply = new PostReply(['content' => $request->content]);

        $newPostReply->user()->associate(auth()->user());

        $newPostReply->post()->associate($post);

        if ($postReply) {
            $postReply->reply()->save($newPostReply);

            return redirect()->back()->withStatus('Comment successfully created.');
        }
        $newPostReply->save();

        if ($post->user->reply_email_notification) {
            Mail::to($post->user->email)->send(new ReplyToPost(
                $this->replyContent = $newPostReply->content,
                $this->replyUsername = $newPostReply->user->username,
                $this->postUsername = $post->user->username,
                $this->postTitle = $post->title,
                $this->postContent = $post->content,
            ));
        }

        return redirect()->back()->withStatus('Postreply successfully created.');
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
        $this->authorize('update', PostReply::class);

        // Show the form...
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
        $this->authorize('update', PostReply::class);

        // Update the post reply...
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
        $this->authorize('delete', PostReply::class);

        // Delete the post reply...
    }
}
