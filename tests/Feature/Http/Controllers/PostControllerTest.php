<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function it_should_return_the_post_create_view()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('posts.create'));

        $response->assertViewIs('posts.create');
    }

    /**
     * @test
     */
    public function it_stores_a_post_and_redirects_with_status()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $title = $this->faker->name;
        $content = $this->faker->sentence;

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'title' => $title,
            'content' => $content,
            'category_id' => $category->id,
        ]);

        $response->assertRedirect(route('category.show', $category->id));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('status', 'Post successfully created.');

        $this->assertDatabaseHas('posts', [
            'title' => $title,
            'content' => $content,
            'category_id' => $category->id,
        ]);
    }

    /**
     * @test
     */
    public function it_does_not_store_a_post_with_no_category_provided()
    {
        $user = User::factory()->create();

        $title = $this->faker->name;
        $content = $this->faker->sentence;

        $this->assertDatabaseCount('posts', 0);

        $response = $this->from(route('posts.create'))->actingAs($user)->post(route('posts.store'), [
            'title' => $title,
            'content' => $content,
            'category_id' => null,
        ]);

        $this->assertDatabaseCount('posts', 0);

        $response->assertSessionHasErrors('category_id');
        $response->assertRedirect(route('posts.create'));
    }

    /**
     * @test
     */
    public function it_does_not_store_a_post_with_no_existing_category_provided()
    {
        $user = User::factory()->create();

        Category::factory()->create();

        $title = $this->faker->name;
        $content = $this->faker->sentence;

        $this->assertDatabaseCount('posts', 0);

        $response = $this->from(route('posts.create'))->actingAs($user)->post(route('posts.store'), [
            'title' => $title,
            'content' => $content,
            'category_id' => 2,
        ]);

        $this->assertDatabaseCount('posts', 0);

        $response->assertRedirect(route('posts.create'));
    }

    /**
     * @test
     */
    public function it_does_not_store_a_post_with_no_content_and_title_provided()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->assertDatabaseCount('posts', 0);

        $response = $this->from(route('posts.create'))->actingAs($user)->post(route('posts.store'), [
            'title' => null,
            'content' => null,
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseCount('posts', 0);

        $response->assertSessionHasErrors(['title', 'content']);

        $response->assertRedirect(route('posts.create'));
    }

    /**
     * @test
     */
    public function it_does_not_store_a_post_when_the_user_is_not_authenticated()
    {
        $category = Category::factory()->create();

        $title = $this->faker->name;
        $content = $this->faker->sentence;

        $this->assertDatabaseCount('posts', 0);

        $response = $this->from(route('posts.create'))->post(route('posts.store'), [
            'title' => $title,
            'content' => $content,
            'category_id' => $category->id,
        ]);

        $this->assertDatabaseCount('posts', 0);

        $response->assertRedirect(route('home'));
    }
}
