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
            'user_id' => User::all()->random()->id,
            'post_id' => Post::all()->random()->id,
            'parent_id' => $this->faker->optional()->numberBetween(1,100),
        ];
    }
}
