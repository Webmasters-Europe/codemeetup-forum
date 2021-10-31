<?php

namespace Tests\Feature\Http\Livewire;

use App\Http\Livewire\CreatePost as CreatePostComponent;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreatePostTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function page_contains_post_form_livewire_component(): void
    {
        $user = User::factory()->create()->assignRole('user');
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->get(route('posts.create', $category));

        $response->assertSeeLivewire('create-post');
    }

    /**
     * @test
     */
    public function it_stores_a_post_and_redirects_with_status(): void
    {
        $user = User::factory()->create()->assignRole('user');
        $this->actingAs($user);

        $category = Category::factory()->create();
        $title = $this->faker->name;
        $content = $this->faker->sentence;

        Livewire::test(CreatePostComponent::class, ['category' => $category])
            ->set('title', $title)
            ->set('content', $content)
            ->call('submitForm')
            ->assertRedirect(route('category.show', $category->id))
            ->assertSessionHas('status', 'Post successfully created.')
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('posts', [
            'title' => $title,
            'content' => $content,
            'category_id' => $category->id,
        ]);
    }

    /**
     * @test
     */
    public function it_does_not_store_a_post_with_no_content_and_title_provided(): void
    {
        $user = User::factory()->create()->assignRole('user');
        $this->actingAs($user);

        $category = Category::factory()->create();

        $this->assertDatabaseCount('posts', 0);

        Livewire::test(CreatePostComponent::class, ['category' => $category])
            ->call('submitForm')
            ->assertHasErrors(['title' => 'required', 'content' => 'required'])
            ->assertViewIs('livewire.create-post');

        $this->assertDatabaseCount('posts', 0);
    }

    /**
     * @test
     */
    public function it_does_not_store_a_post_when_the_user_is_not_authenticated(): void
    {
        $category = Category::factory()->create();

        $title = $this->faker->name;
        $content = $this->faker->sentence;

        $this->assertDatabaseCount('posts', 0);

        Livewire::test(CreatePostComponent::class, ['category' => $category])
            ->set('title', $title)
            ->set('content', $content)
            ->call('submitForm')
            ->assertForbidden();

        $this->assertDatabaseCount('posts', 0);
    }

    /**
     * @test
     */
    public function it_does_not_store_a_post_when_the_user_has_no_permission(): void
    {
        $user = User::factory()->create()->assignRole('user');
        $userRole = Role::findByName('user');
        $userRole->revokePermissionTo('create posts');
        $this->actingAs($user);

        $category = Category::factory()->create();

        $title = $this->faker->name;
        $content = $this->faker->sentence;

        $this->assertDatabaseCount('posts', 0);

        Livewire::test(CreatePostComponent::class, ['category' => $category])
            ->set('title', $title)
            ->set('content', $content)
            ->call('submitForm')
            ->assertForbidden();

        $this->assertDatabaseCount('posts', 0);
    }
}
