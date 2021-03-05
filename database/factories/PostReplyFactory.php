<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\PostReply;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostReplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostReply::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->text(150),
            'user_id' => User::inRandomOrder()->first() ?: User::factory(),
            'post_id' => Post::inRandomOrder()->first() ?: Post::factory(),
            'parent_id' => $this->getParent(),
        ];
    }
    private function getParent()
    {
        $posts = Post::all();
        $replies = PostReply::all();
        $parents = $posts->merge($replies);
        if ($parents->isEmpty()) {
            return Post::factory();
        }
        return $parents->random();
    }
}
