<?php

namespace Tests\Feature\Feature\Http\Livewire;

use App\Http\Livewire\AdminAreaCategories;
use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Category;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminAreaCategoriesTest extends TestCase
{
    use RefreshDatabase;
    private $testCategory;
    private $testCategory2;

    protected function setUp(): void
    {
        parent::setUp();

        Permission::create(['name' => 'admin categories']);
        $this->moderatorRole = Role::create(['name' => 'moderator']);
        $this->moderatorRole->givePermissionTo('admin categories');

        $this->testCategory = Category::factory()->create();
        $this->testCategory2 = Category::factory()->create();

        $this->testCategory->name = 'Michael';
        $this->testCategory2->name = "Rhea";
        $this->testCategory->description = 'Österreich';
        $this->testCategory2->description = "Deutschland";
        $this->testCategory->save();
        $this->testCategory2->save();

        $this->authUser = User::factory()->create()->assignRole('moderator');
        $this->actingAs($this->authUser);
    }

    /** @test */
    public function page_contains_categories_table_livewire_component()
    {

        $response = $this->get(route('admin-area.categories'));

        $response->assertSeeLivewire('admin-area-categories');
    }

    /** @test */
    public function does_not_show_categories_table_when_the_user_has_no_permission()
    {
        $this->moderatorRole->revokePermissionTo('admin categories');
        $response = $this->get(route('admin-area.categories'));
        $response->assertForbidden()->assertDontSeeLivewire('admin-area-categories');
    }

    /** @test */
    public function shows_categories_in_the_table()
    {
        $this->assertDatabaseCount('categories', 2);

        Livewire::test(AdminAreaCategories::class)
            ->call('render')
            ->assertSee($this->testCategory->name)
            ->assertSee($this->testCategory->description)
            ->assertSeeHtml('<i class="fas fa-trash"></i>')
            ->assertSeeHtml('<i class="fas fa-edit"></i>');
    }

    /** @test */
    public function allows_to_search_for_categories()
    {
        $this->testCategory->name = 'Die besten Programmierer aller Zeiten';
        $this->testCategory->description = 'Michael und Rhea sind die ...';
        $this->testCategory->save();

        // Global search:
        Livewire::test(AdminAreaCategories::class)
            ->call('render')
            ->assertSee($this->testCategory->name)
            ->set('search', '123')
            ->assertDontSee($this->testCategory->name)
            ->set('search', 'besten')
            ->assertSee($this->testCategory->name)
            ->set('search', 'Rhea')
            ->assertSee($this->testCategory->description);


        // Search by name:
        Livewire::test(AdminAreaCategories::class)
            ->call('render')
            ->set('searchName', 'rammier')
            ->assertSee($this->testCategory->name)
            ->set('searchName', '123')
            ->assertDontSee($this->testCategory->name);

        // Search by description:
        Livewire::test(AdminAreaCategories::class)
            ->call('render')
            ->set('searchDescription', 'Niclas')
            ->assertDontSee($this->testCategory->description)
            ->set('searchDescription', 'Mich')
            ->assertSee($this->testCategory->description);

        // Combined search:
        Livewire::test(AdminAreaCategories::class)
            ->call('render')
            ->set('searchName', 'Prog')
            ->assertSee($this->testCategory->name)
            ->set('searchDescription', 'foo')
            ->assertDontSee($this->testCategory->description)
            ->set('searchDescription', 'Rhea')
            ->assertSee($this->testCategory->description);
    }

    /** @test */
    public function allows_to_sort_categories()
    {

        Livewire::test(AdminAreaCategories::class)
            ->call('render')
            ->set('sortBy', 'name')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder(['Michael', 'Rhea'])
            ->set('sortDirection', 'desc')
            ->assertSeeInOrder(['Rhea', 'Michael'])
            ->set('sortBy', 'description')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder(['Deutschland', 'Österreich'])
            ->set('sortDirection', 'desc')
            ->assertSeeInOrder(['Österreich', 'Deutschland']);
    }

    /** @test */
    public function shows_deleted_categories_when_table_view_is_changed()
    {
        Livewire::test(AdminAreaCategories::class)
            ->call('render')
            ->assertSee('Michael')
            ->set('showDeletedCategories', true)
            ->assertDontSee('Michael');

        $this->assertDatabaseHas('categories', [
            'name' => 'Michael',
            'deleted_at' => null
        ]);

        $this->testCategory->deleted_at = '2021-04-01 15:36:41';
        $this->testCategory->save();

        $this->assertDatabaseHas('categories', [
            'name' => 'Michael',
            'deleted_at' => '2021-04-01 15:36:41'
        ]);

        Livewire::test(AdminAreaCategories::class)
            ->call('render')
            ->assertDontSee('Michael')
            ->set('showDeletedCategories', true)
            ->assertSee('Michael');
    }

    /** @test */
    public function allows_to_delete_and_restore_categories()
    {

        $testCategoryId = $this->testCategory->id;

        // Delete category:
        Livewire::test(AdminAreaCategories::class)
            ->call('render')
            ->assertDontSee('Delete this Category')
            ->call('selectCategory',  $testCategoryId, 'delete')
            
            ->call('delete')
            ->assertDontSee($this->testCategory->name)
            ->set('showDeletedCategories', true)
            ->assertSee($this->testCategory->name);

        $this->assertDatabaseMissing('categories', [
            'name' => $this->testCategory->name,
            'deleted_at' => null
        ]);

        // Restore category:
        /* Livewire::test(AdminAreaCategories::class)
            ->set('showDeletedCategories', true)
            ->assertSee('Michael')
            ->assertSeeHtml('<i class="fas fa-trash-restore"></i>')
            ->call('selectCategory',  $testCategoryId, 'restore')
            ->assertSee('Restore this Category')
            ->call('restore')
            ->assertDispatchedBrowserEvent('closeRestoreModelInstanceModal')
            ->assertDontSee('Michael')
            ->set('showDeletedCategories', false)
            ->assertSee('Michael');

        $this->assertDatabaseHas('categories', [
            'name' => 'Michael',
            'deleted_at' => null
        ]); */
    }

    /** @test */
    public function can_add_a_new_category()
    {
        Livewire::test(AdminAreaCategories::class)
            ->call('render')
            ->assertSee('Add new Category')
            ->call('showCategoryForm')
            ->assertDispatchedBrowserEvent('openAddModelInstanceModal')
            ->call('addNewCategory')
            ->assertSee('The name field is required.')
            ->set('name', 'Meine neue Kategorie')
            ->call('addNewCategory')
            ->assertDispatchedBrowserEvent('closeAddModelInstanceModal');

        $this->assertDatabaseHas('categories', [
            'name' => 'Meine neue Kategorie',
        ]);
    }

    /** @test */
    /* public function can_edit_a_category()
    {
        Livewire::test(AdminAreaCategories::class)
            ->call('render')
            ->assertSeeHtml('<i class="fas fa-edit"></i>')
            ->call('selectCategory',  $this->testCategory->id, 'update')
            ->assertDispatchedBrowserEvent('openUpdateModelInstanceModal')
            ->assertSee('Update Category')
            ->set('name', 'Meine editierte Kategorie')
            ->call('update')
            ->assertDispatchedBrowserEvent('closeUpdateModelInstanceModal');

        $this->assertDatabaseHas('categories', [
            'name' => 'Meine editierte Kategorie',
        ]);
    } */
}
