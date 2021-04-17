<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AtLeastOneUserRoleRequired implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $chosenRoles)
    {
        foreach ($chosenRoles as $key => $value) {
            if ($value) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A user must have at least one role.';
    }
}
