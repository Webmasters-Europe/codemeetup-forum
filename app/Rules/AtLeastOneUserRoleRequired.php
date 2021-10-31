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
     */
    public function passes($attribute, $value): bool
    {
        foreach ($value as $isChosen) {
            if ($isChosen) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'A user must have at least one role.';
    }
}
