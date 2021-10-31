<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $user;
    private $moderator;
    private $category;
    private $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create()->assignRole('user');
        $this->moderator = User::factory()->create()->assignRole('moderator');
        $this->category = Category::factory()->create();
        $this->post = new Post([
            'title' => 'Test',
            'content' => 'Test',
        ]);
        $this->post->category()->associate($this->category);
        $this->user->posts()->save($this->post);
    }

    /**
     * @test
     */
    public function it_should_return_the_post_create_view(): void
    {
        $response = $this->actingAs($this->user)->get(route('posts.create', $this->category));
        $response->assertViewIs('posts.create');
    }

    /**
     * @test
     */
    public function a_moderator_can_delete_any_posts(): void
    {
        $this->assertDatabaseHas('posts', [
            'title' => 'Test',
            'content' => 'Test',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'deleted_at' => null,
        ]);

        $this->actingAs($this->moderator);
        $this->delete(route('posts.destroy', $this->post));
        $this->assertSoftDeleted('posts', [
            'id' => $this->post->id,
        ]);
    }

    /**
     * @test
     */
    public function a_user_can_delete_own_posts(): void
    {
        $this->assertDatabaseHas('posts', [
            'title' => 'Test',
            'content' => 'Test',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'deleted_at' => null,
        ]);

        $this->actingAs($this->user);

        $response = $this->delete(route('posts.destroy', $this->post));
        $response->assertStatus(302);

        $this->assertSoftDeleted('posts', [
            'id' => $this->post->id,
        ]);
    }

    /**
     * @test
     */
    public function a_user_cannot_delete_posts_from_other_users(): void
    {
        $this->assertDatabaseHas('posts', [
            'title' => 'Test',
            'content' => 'Test',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'deleted_at' => null,
        ]);

        $this->user2 = User::factory()->create()->assignRole('user');

        $this->actingAs($this->user2);

        $response = $this->delete(route('posts.destroy', $this->post));
        $response->assertStatus(403);

        $this->assertDatabaseHas('posts', [
            'title' => 'Test',
            'content' => 'Test',
            'category_id' => $this->category->id,
            'user_id' => $this->user->id,
            'deleted_at' => null,
        ]);
    }

    /**
     * @test
     */
    public function a_moderator_can_update_posts(): void
    {
        $response = $this
            ->actingAs($this->moderator)
            ->put(route('posts.update', $this->post->id), [
                'title' => 'updated title',
                'content' => 'updated content',
            ]);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('posts', [
            'title' => 'updated title',
            'content' => 'updated content',
        ]);

        $response->assertRedirect(route('posts.show', $this->post));
        $response->assertSessionHas('status', 'Post successfully updated.');
    }

    /**
     * @test
     */
    public function a_user_cannot_edit_posts(): void
    {
        $this->actingAs($this->user)
            ->put(route('posts.update', $this->post->id), [
                'title' => 'updated title',
                'content' => 'updated content',
            ]);

        $this->assertDatabaseMissing('posts', [
            'title' => 'updated title',
            'content' => 'updated content',
        ]);
    }
}
