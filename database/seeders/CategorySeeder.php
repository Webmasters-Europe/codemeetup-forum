<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'Katzen', 'description' => 'Für Thomas']);
        Category::create(['name' => 'Schneeglöckchen', 'description' => 'Für Michael']);
        Category::factory(9)->create();
    }
}
