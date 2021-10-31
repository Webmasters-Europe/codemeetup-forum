<?php

namespace Database\Seeders;

use App\Models\PostReply;
use Illuminate\Database\Seeder;

class PostReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PostReply::factory(2)->create();
    }
}
