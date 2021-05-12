<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                __('primary_color') => 'required|string|max:7',
                __('button_text_color') => 'required|string|max:7',
                __('category_icons_color') => 'required|string|max:7',
                __('forum_name') => 'required|string',
                __('forum_image') => 'sometimes|image|max:5000',
                __('number_categories_startpage') => 'required|numeric',
                __('number_last_entries_startpage') => 'required|numeric',
                __('number_posts') => 'required|numeric',
                __('email_contact_page') => 'nullable|string|email|max:255|',
                __('imprint_page') => 'required|max:5000',
                __('copyright') => 'required|string',
            ];
    }
}
