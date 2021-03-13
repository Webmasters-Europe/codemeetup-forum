<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->is(request()->user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validation_array = [
            'name' => 'sometimes|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,'.$this->user->id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$this->user->id,
            'avatar' => 'sometimes|image|max:5000',
        ];

        if ($this->password) {
            $validation_array = array_merge($validation_array, [
                'password' => 'string|min:8|confirmed',
            ]);
        }

        return $validation_array;
    }
}
