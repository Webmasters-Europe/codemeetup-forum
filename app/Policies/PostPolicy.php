<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any posts.
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the post.
     */
    public function view(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create posts.
     */
    public function create(User $user)
    {
        if ($user->can('create posts')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the post.
     */
    public function update(User $user)
    {
        if ($user->can('update posts')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the post.
     */
    public function delete(User $user, Post $post)
    {   
       
        if ($user->can('delete any posts') || ($user->can('delete own posts') && $user->is($post->user))){
            return true;
        }
    }
}
