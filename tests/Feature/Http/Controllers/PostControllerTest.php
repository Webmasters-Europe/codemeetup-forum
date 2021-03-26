<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'create posts']);
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('create posts');
    }

    /**
     * @test
     */
    public function it_should_return_the_post_create_view()
    {
        $user = User::factory()->create()->assignRole('user');
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->get(route('posts.create', $category));

        $response->assertViewIs('posts.create');
    }

}
