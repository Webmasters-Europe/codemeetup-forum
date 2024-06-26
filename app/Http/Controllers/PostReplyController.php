<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostReplyRequest;
use App\Models\Post;
use App\Models\PostReply;
use App\Notifications\ReplyToPost as NotificationsReplyToPost;

class PostReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);

        $this->middleware('verified', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Post $post): void
    {
        $this->authorize('viewAny', PostReply::class);

        // List post replies...
    }

    /**
     * @param \App\Models\PostReply|null $postReply
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Illuminate\Database\Eloquent\InvalidCastException
     * @throws \LogicException
     * @throws \Illuminate\Database\Eloquent\JsonEncodingException
     */
    public function store(PostReplyRequest $request, Post $post, PostReply $postReply = null)
    {
        $this->authorize('create', PostReply::class);

        $newPostReply = new PostReply(['content' => $request->content]);

        $newPostReply->user()->associate(auth()->user());

        $newPostReply->post()->associate($post);

        if ($postReply) {
            $postReply->reply()->save($newPostReply);

            return redirect()->back()->withStatus(__('Comment successfully created.'));
        }
        $newPostReply->save();

        // Notifications
        $post->user->notify(new NotificationsReplyToPost($newPostReply));

        return redirect()->back()->withStatus(__('Postreply successfully created.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post, PostReply $postReply): void
    {
        $this->authorize('update', PostReply::class);

        // Show the form...
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     */
    // public function update(PostReplyRequest $request, PostReply $postReply): \Illuminate\Http\Response
    public function update(PostReplyRequest $request, PostReply $postReply): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('update', PostReply::class);
        $postReply->content = $request->content;
        $postReply->save();

        return redirect()->route('posts.show', $postReply->post_id)->withStatus(__('Reply has been updated.'));
        // Update the post reply...
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     */
    // public function destroy(PostReply $postReply): \Illuminate\Http\Response
    public function destroy(PostReply $postReply): \Illuminate\Http\RedirectResponse
    {
        $this->authorize('delete', [PostReply::class, $postReply]);

        $post = $postReply->post_id;
        $postReply->delete();

        return redirect()->route('posts.show', $post)->withStatus(__('Reply has been deleted.'));
    }
}
