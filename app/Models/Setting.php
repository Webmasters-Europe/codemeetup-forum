<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'primary_color',
        'button_text_color',
        'category_icons_color',
        'forum_name',
        'forum_image',
        'number_categories_startpage',
        'number_last_entries_startpage',
        'number_posts',
        'email_contact_page',
        'imprint_page',
        'copyright',
    ];
}
