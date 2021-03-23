<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_shows_a_users_profile_page_for_auth_users()
    {
        $user = User::factory()->create();
        $response = $this->be($user)->get(route('users.show', $user));
        $response->assertViewIs('profiles.show');
    }

    /**
     * @test
     */
    public function a_user_can_edit_his_profile()
    {
        $user = User::factory()->create();
        $response = $this->be($user)->get(route('users.edit', $user));
        $response->assertViewIs('profiles.edit');
    }

    /**
     * @test
     */
    public function a_user_can_update_name_username_and_email()
    {
        $user = User::factory()->create();
        $response = $this->be($user)->post(route('users.update', $user), [
            'name' => 'updated name',
            'username' => 'updated username',
            'email' => 'updated email',
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('home'));
    }
}
