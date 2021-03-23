<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any category.
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the category.
     */
    public function view(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create category.
     */
    public function create(User $user)
    {
        if ($user->can('create categories')) {
            return true;
        }
    }

    /**
     * Determine whether the user can update the category.
     */
    public function update(User $user)
    {
        if ($user->can('update categories')) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the category.
     */
    public function delete(User $user)
    {
        if ($user->can('delete categories')) {
            return true;
        }
    }

}
