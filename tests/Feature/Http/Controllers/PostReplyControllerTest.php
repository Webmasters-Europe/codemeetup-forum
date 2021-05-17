<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Post;
use App\Models\PostReply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostReplyControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_stores_a_post_reply_and_redirects_with_status()
    {
        $user = User::factory()->create()->assignRole('user');
        $post = Post::factory()->create();
        $content = $this->faker->sentence;

        $response = $this
            ->from(route('posts.show', $post))
            ->actingAs($user)
            ->post(route('replies.store', $post), [
                'content' => $content,
            ]);

        $response->assertRedirect(route('posts.show', $post));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('status', 'Postreply successfully created.');

        $this->assertDatabaseHas('post_replies', [
            'content' => $content,
            'user_id' => $user->id,
            'post_id' => $post->id,
            'parent_id' => null,
        ]);
    }

    /**
     * @test
     */
    public function it_stores_a_comment_to_a_post_reply_and_redirects_with_status()
    {
        $user = User::factory()->create()->assignRole('user');
        $post = Post::factory()->create();
        $postReply = PostReply::factory()->create();
        $content = $this->faker->sentence;

        $response = $this
            ->from(route('posts.show', $post->id))
            ->actingAs($user)
            ->post(route('replies.store', [$post, $postReply]), [
                'content' => $content,
            ]);

        $response->assertRedirect(route('posts.show', $post->id));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('status', 'Comment successfully created.');

        $this->assertDatabaseHas('post_replies', [
            'content' => $content,
            'user_id' => $user->id,
            'post_id' => $post->id,
            'parent_id' => $postReply->id,
        ]);
    }

    /**
     * @test
     */
    public function it_does_not_store_a_post_reply_with_no_content_provided()
    {
        $user = User::factory()->create()->assignRole('user');
        $post = Post::factory()->create();

        $response = $this
            ->from(route('posts.show', $post->id))
            ->actingAs($user)
            ->post(route('replies.store', $post), []);

        $this->assertDatabaseCount('post_replies', 0);
        $response->assertSessionHasErrors('content');
        $response->assertRedirect(route('posts.show', $post->id));
    }

    /**
     * @test
     */
    public function it_does_not_store_a_post_reply_when_the_user_is_not_authenticated()
    {
        $post = Post::factory()->create();
        $content = $this->faker->sentence;

        $response = $this
            ->from(route('posts.show', $post->id))
            ->post(route('replies.store', $post), [
                'content' => $content,
            ]);

        $this->assertDatabaseCount('post_replies', 0);

        $response->assertRedirect(route('home'));
    }


    /**
     * @test
     */
    public function a_moderator_can_delete_post_replies()
    {
        $moderator = User::factory()->create()->assignRole('moderator');
        $user = User::factory()->create()->assignRole('user');
        $post = Post::factory()->create();
        $postReply = PostReply::factory()->create();
        $content = $this->faker->sentence;

        $this->from(route('posts.show', $post->id))
            ->actingAs($user)
            ->post(route('replies.store', [$post, $postReply]), [
            'content' => $content,
        ]);
        
        $this->assertDatabaseHas('post_replies', [
            'content' => $content,
        ]);
        
        $this->actingAs($moderator);
        $this->delete(route('replies.destroy', $postReply));
        $this->assertSoftDeleted('post_replies', [
            'id' => $postReply->id
        ]);
        
    }


    /**
     * @test
     */
    public function a_user_can_delete_his_own_post_replies()
    {
        $user = User::factory()->create()->assignRole('user');
        $post = Post::factory()->create();
        $postReply = PostReply::factory()->create();
        $content = $this->faker->sentence;

        $this->from(route('posts.show', $post->id))
            ->actingAs($user)
            ->post(route('replies.store', [$post, $postReply]), [
            'content' => $content,
        ]);
        
        $this->assertDatabaseHas('post_replies', [
            'content' => $content,
        ]);
        
        $this->actingAs($user);
        $response = $this->delete(route('replies.destroy', $postReply));
        $response->assertStatus(302);
        $this->assertSoftDeleted('post_replies', [
            'id' => $postReply->id
        ]);

    }


     /**
     * @test
     */
    public function a_user_cannot_delete_post_replies_from_other_users()
    {
        $user = User::factory()->create()->assignRole('user');
        $post = Post::factory()->create();
        $postReply = PostReply::factory()->create();
        $content = $this->faker->sentence;

        $this->from(route('posts.show', $post->id))
            ->actingAs($user)
            ->post(route('replies.store', [$post, $postReply]), [
            'content' => $content,
        ]);
        
        $this->assertDatabaseHas('post_replies', [
            'content' => $content,
        ]);
        
        $this->user2 = User::factory()->create()->assignRole('user');

        $this->actingAs($this->user2);
        $response = $this->delete(route('replies.destroy', $postReply));
        $response->assertStatus(403);
        
        $this->assertDatabaseHas('post_replies', [
            'content' => $content,
        ]);
    }

    /**
     * @test
     */
    public function a_moderator_can_update_post_replies()
    {
        $moderator = User::factory()->create()->assignRole('moderator');
        // create reply
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $reply = new PostReply();
        $reply->content = 'Content';
        $reply->post()->associate($post);
        $reply->user()->associate($user);
        $reply->save();

        $response = $this
        ->actingAs($moderator)
        ->patch(route('replies.update', $reply->id), [
            'content' => 'updated content'
        ]);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('post_replies', [
            'content' => 'updated content'
        ]);

        $response->assertRedirect(route('posts.show', $reply->post_id));
        $response->assertSessionHas('status', 'Reply has been updated.');
        
    }

    public function a_user_cannot_update_post_replies()
    {
        // create reply
        $post = Post::factory()->create();
        $user = User::factory()->create();
        $reply = new PostReply();
        $reply->content = 'Content';
        $reply->post()->associate($post);
        $reply->user()->associate($user);
        $reply->save();

        $response = $this
        ->actingAs($user)
        ->patch(route('replies.update', $reply->id), [
            'content' => 'updated content'
        ]);
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('post_replies', [
            'content' => 'updated content'
        ]);
        
    }


}