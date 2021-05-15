<?php

namespace Database\Seeders;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::factory(50)->hasCategory()->create();
        Post::factory(50)->hasCategory()->create(['created_at' => Carbon::now()->subMonths(1)]);
    }
}
