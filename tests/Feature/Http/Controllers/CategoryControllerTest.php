<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function it_should_return_the_categories_show_view_with_posts()
    {
        $category = Category::factory()->create();

        $response = $this->get(route('category.show', $category->id));

        $response->assertViewIs('categories.show');
        $response->assertViewHas('posts');
    }

    /**
     * @test
     */
    public function it_should_return_404_status_code_when_category_is_unknown()
    {
        $response = $this->get(route('category.show', '1'));

        $response->assertStatus(404);
    }
}
