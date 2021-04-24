<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any users.
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the user.
     */
    public function view(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create the user.
     */
    public function create(?User $user)
    {
        return false;
    }

    /**
     * Determine whether the auth user can update the user.
     */
    public function update(User $authUser, User $user)
    {
        if ($authUser->can('edit own profile')) {
            return $user->id == $authUser->id;
        }

        if ($authUser->can('edit any profile')) {
            return true;
        }
    }

    /**
     * Determine whether the auth user can delete the user.
     */
    public function delete(User $authUser, User $user)
    {
        if ($authUser->can('delete own user')) {
            return $user->id === $authUser->id;
        }

        if ($authUser->can('delete any user')) {
            return true;
        }
    }
}
