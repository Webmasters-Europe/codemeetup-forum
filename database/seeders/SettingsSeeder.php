<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'primary_color' => '#23272b',
            'button_text_color' => '#ffffff',
            'category_icons_color' => '#23272b',
            'forum_name' => 'Codemeetup-Forum',
            'number_categories_startpage' => 10,
            'number_last_entries_startpage' => 3,
            'number_posts' => 10,
            'imprint_page' => 'This is the Imprint Page. Please go to Settings to write your own text.',
            'copyright' => 'Alena, Anette, Christian, Michael, Niclas, Rhea, Thomas',
        ]);
    }
}
