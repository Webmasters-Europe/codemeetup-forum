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
                'email_contact_page' => 'nullable|string|email|max:255|',
                'imprint_page' => 'required|max:5000',
                'copyright' => 'required|string',
            ];
    }


    public function messages()
{
    return [
        'primary_color.required' => __('The main color field must not be empty.'),
        'primary_color.max' => __('Main color must be a HEX code and may have a maximum of 7 characters.'),
        'primary_color.string' => __('Main color must be a HEX code and may have a maximum of 7 characters.'),
        'button_text_color.required' => __('The color field of the button label must not be empty.'),
        'button_text_color.max' => __('The color of the button labeling must be a HEX code and may have a maximum of 7 characters.'),
        'button_text_color.string' => __('The color of the button labeling must be a HEX code and may have a maximum of 7 characters.'),
        'category_icons_color.required' => __('The color field of the category icons must not be empty.'),
        'category_icons_color.max' => __('Color of the category icons must be a HEX code and may have a maximum of 7 characters.'),
        'category_icons_color.string' => __('Color of the category icons must be a HEX code and may have a maximum of 7 characters.'),
        'forum_name.required' => __('The forum title cannot be empty.'),
        'forum_name.string' => __('The title of the forum must be a string.'),
        'number_categories_startpage.required' => __('The number of categories displayed on the start page must not be empty.'),
        'number_categories_startpage.numeric' => __('The number of categories displayed on the start page must be numeric.'),
        'number_last_entries_startpage.required' => __('The number of the last posts on the start page must not be empty.'),
        'number_last_entries_startpage.numeric' => __('The number of the last posts on the start page must be numeric.'),
        'number_posts.required' => __('The number of posts cannot be empty.'),
        'number_posts.numeric' => __('The number of posts must be numeric.'),
        'imprint_page.required' => __('You have to enter a text for the imprint.'),
        'imprint_page.max' => __('The text for the imprint may not be longer than 5000 characters.'),
        'copyright.required' => __('The Copyright field cannot be empty.'),
        'copyright.string' => __('The Copyright field must contain a character string.'),
        'email_contact_page.email' => __('You have to enter an email address in the field for the contact page.'),
    ];
}
}
