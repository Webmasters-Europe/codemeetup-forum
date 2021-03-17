<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_should_return_the_welcome_view_for_an_authenticated_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('home'));

        $response->assertViewIs('welcome');
        $response->assertViewHas('categories');
    }

    /**
     * @test
     */
    public function it_should_return_the_welcome_view_for_an_unauthenticated_user()
    {
        $response = $this->get(route('home'));

        $response->assertViewIs('welcome');
        $response->assertViewHas('categories');
    }

}
