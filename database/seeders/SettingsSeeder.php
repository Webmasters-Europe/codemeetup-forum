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
            'primary_color' => '#f96',
            'forum_name' => 'Codemeetup-Forum', 
            'forum_image' => '', 
            'number_categories_startpage' => 10, 
            'number_last_entries_startpage' => 3, 
            'contact_page' => 'This is the Contact Page.',
            'imprint_page' => 'This is the Imprint Page.',
            'copyright_page' => 'Copyright 2021 by Alena, Anette, Christian, Michael, Niclas, Rhea, Thomas'
        ]);
    }
}
