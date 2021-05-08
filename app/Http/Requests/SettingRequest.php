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
                'primary_color' => 'required|string|max:7',
                'button_text_color' => 'required|string|max:7',
                'category_icons_color' => 'required|string|max:7',
                'forum_name' => 'required|string',
                'forum_image' => 'sometimes|image|max:5000',
                'number_categories_startpage' => 'required|numeric',
                'number_last_entries_startpage' => 'required|numeric',
                'number_posts' => 'required|numeric',
                'contact_page' => 'required|max:5000',
                'imprint_page' => 'required|max:5000',
                'copyright_page' => 'required|string',
            ];
    }
}
