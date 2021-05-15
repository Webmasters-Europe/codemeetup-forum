<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any post replies.
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the post reply.
     */
    public function view(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create post replies.
     */
    public function create(User $user)
    {
        if ($user->can('create post replies')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the post reply.
     */
    public function update(User $user)
    {
        if ($user->can('update post replies')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the post reply.
     */
    public function delete(User $user)
    {
        if ($user->can('delete any post replies') || ($user->can('delete own post replies') && $user == auth()->user())) {
            return true;
        }
    }
}
