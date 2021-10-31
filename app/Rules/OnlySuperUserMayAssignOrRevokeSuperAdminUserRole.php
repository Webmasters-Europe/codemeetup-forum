<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OnlySuperUserMayAssignOrRevokeSuperAdminUserRole implements Rule
{
    private $user;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     */
    public function passes($attribute, $value): bool
    {
        if (auth()->user()->hasRole('super-admin')) {
            return true;
        }

        $oldValueSuperAdminRole = $this->user->hasRole('super-admin');

        foreach ($value as $key => $isChosen) {
            if ($key === 'super-admin') {
                $newValueSuperAdminRole = $isChosen;
                break;
            }
        }

        if (isset($newValueSuperAdminRole) && $oldValueSuperAdminRole != $newValueSuperAdminRole) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'You are not allowed to assign or revoke the super-admin role.';
    }
}
