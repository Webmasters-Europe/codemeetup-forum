<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'primary_color' => '#23272b',
            'button_text_color' => '#ffffff',
            'category_icons_color' => '#23272b',
            'forum_name' => 'Codemeetup-Forum',
            'number_categories_startpage' => 10,
            'number_last_entries_startpage' => 3,
            'number_posts' => 10,
            'contact_page' => 'This is the Contact Page.',
            'imprint_page' => 'This is the Imprint Page.',
            'copyright_page' => 'Copyright 2021 by Alena, Anette, Christian, Michael, Niclas, Rhea, Thomas',
        ]);
    }
}
