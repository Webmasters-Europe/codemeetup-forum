<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SettingControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    private $testAdmin;
    private $testUser;

    protected function setUp(): void
    {
        parent::setUp();
        // create testUser and testAdmin
        $this->testUser = User::factory()->create()->assignRole('user');
        $this->testModerator = User::factory()->create()->assignRole('moderator');
        $this->testAdmin = User::factory()->create()->assignRole('super-admin');
    }

    /**
     * @test
     */
    public function it_shows_settings_page_only_for_admins()
    {
        $response = $this->actingAs($this->testAdmin)->get(route('admin-area.settings'));
        $response->assertViewIs('admin-area.settings');
        $response->assertSee('Primary Color (Header, Footer, Button)');
        $response = $this->actingAs($this->testUser)->get(route('admin-area.settings'));
        $response->assertForbidden();
        $response = $this->actingAs($this->testModerator)->get(route('admin-area.settings'));
        $response->assertForbidden();
    }

    /**
     * @test
     */
    public function it_checks_if_only_the_first_instance_of_settings_is_used()
    {
        $setting = Setting::create([
            'primary_color' => 'test',
            'button_text_color' => 'test',
            'category_icons_color' => 'test',
            'forum_name' => '',
            'number_categories_startpage' => 0,
            'number_last_entries_startpage' => 0,
            'number_posts' => 0,
            'contact_page' => 'test',
            'imprint_page' => 'test',
            'copyright_page' => 'test',
        ]);
        $this->assertDatabaseHas('settings', ['id' => 2]);

        $testPrimaryColor = config('app.settings.primary_color');
        $this->assertStringNotContainsString('test', $testPrimaryColor);
    }

    /**
     * @test
     */
    public function if_can_update_settings_values()
    {
        $testImage = UploadedFile::fake()->image('logo.jpg');

        $response = $this
            ->actingAs($this->testAdmin)
            ->put(route('admin-area.settings.update'), [
            'primary_color' => '#000000',
            'button_text_color' => '#ffffff',
            'category_icons_color' => '#000000',
            'forum_name' => 'test forum_name',
            'number_categories_startpage' => 6,
            'number_last_entries_startpage' => 6,
            'number_posts' => 6,
            'contact_page' => 'test contact page',
            'imprint_page' => 'test impring page',
            'copyright_page' => 'test copyright page',
            'forum_image' => $testImage,
            ]);

        $this->assertDatabaseHas('settings', [
            'primary_color' => '#000000',
            'button_text_color' => '#ffffff',
            'category_icons_color' => '#000000',
            'forum_name' => 'test forum_name',
            'number_categories_startpage' => 6,
            'number_last_entries_startpage' => 6,
            'number_posts' => 6,
            'contact_page' => 'test contact page',
            'imprint_page' => 'test impring page',
            'copyright_page' => 'test copyright page',
            'forum_image' => 'uploads/'.$testImage->hashName(),
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('home'));
        $response->assertSessionHas('status', 'Settings successfully updated.');
    }

    /**
     * @test
     */
    public function it_does_not_update_settings_with_no_values()
    {
        $response = $this
            ->actingAs($this->testAdmin)
            ->put(route('admin-area.settings.update'), [
            'primary_color' => null,
            'button_text_color' => null,
            'category_icons_color' => null,
            'forum_name' => null,
            'number_categories_startpage' => null,
            'number_last_entries_startpage' => null,
            'number_posts' => null,
            'contact_page' => null,
            'imprint_page' => null,
            'copyright_page' => null,
            ]);
        $response->assertSessionHasErrors();
    }
}
