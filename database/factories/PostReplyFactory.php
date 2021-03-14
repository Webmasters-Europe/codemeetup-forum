<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostReply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostReplyFactory extends Factory
{
    private $post;
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
            'post_id' => $this->getPost(),
            'parent_id' =>  $this->getParent(),
        ];
    }

    private function getPost()
    {
        $this->post = Post::inRandomOrder()->first() ?: Post::factory();

        return $this->post;
    }

    private function getParent()
    {
        $parents = PostReply::where('post_id', $this->post->id)->get();

        if ($parents->isEmpty()) {
            return null;
        }

        return $parents->random()->id;
    }
}
