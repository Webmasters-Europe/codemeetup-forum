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

        $validation_array =  [
            'name' => 'sometimes|string|max:255'
        ];

        if ($this->username != auth()->user()->username) {
            $validation_array = array_merge($validation_array, [
                'username' => 'sometimes|string|max:255|unique:users,username',
            ]);
        }

        if ($this->email != auth()->user()->email) {
            $validation_array = array_merge($validation_array, [
                'email' => 'sometimes|string|email|max:255|unique:users,email',
            ]);
        }

        if ($this->password) {
            $validation_array = array_merge($validation_array, [
                'password' => 'string|min:8|confirmed',
            ]);
        }

        return $validation_array;
    }
}
