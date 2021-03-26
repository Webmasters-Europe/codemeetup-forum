<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'edit own profile']);
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('edit own profile');
    }

    /**
     * @test
     */
    public function it_shows_a_users_profile_page_for_auth_users()
    {
        $user = User::factory()->create()->assignRole('user');
        $response = $this->actingAs($user)->get(route('users.show', $user));
        $response->assertViewIs('profiles.show');
    }

    /**
     * @test
     */
    public function a_user_can_edit_his_profile()
    {
        $user = User::factory()->create()->assignRole('user');
        $response = $this->actingAs($user)->get(route('users.edit', $user));
        $response->assertViewIs('profiles.edit');
    }

    /**
     * @test
     */
    public function a_user_can_update_name_username_and_email()
    {
        $user = User::factory()->create()->assignRole('user');

        $response = $this
            ->actingAs($user)
            ->put(route('users.update', $user->id), [
                'name' => 'updated name',
                'username' => 'updated username',
                'email' => 'updated@email.com'
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'updated name',
            'username' => 'updated username',
            'email' => 'updated@email.com'
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('status', 'Profile successfully updated.');
    }
}
