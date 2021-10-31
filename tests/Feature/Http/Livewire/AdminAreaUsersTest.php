<?php

namespace Tests\Feature\Http\Livewire;

use App\Http\Livewire\AdminAreaUsers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminAreaUsersTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    private $authUser;
    private $testUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->testUser = User::create([
            'name' => 'Rolf Liebermann',
            'username' => 'Rolfi',
            'email' => 'rolf.liebermann@example.com',
            'password' => Hash::make('xjkvöljas23lsdfk'),
        ])->assignRole('user');

        $this->authUser = User::factory()->create()->assignRole('moderator');
        $this->actingAs($this->authUser);
    }

    /**
     * @test
     */
    public function page_contains_user_table_livewire_component(): void
    {
        $response = $this->get(route('admin-area.users'));

        $response->assertSeeLivewire('admin-area-users');
    }

    /**
     * @test
     */
    public function it_does_not_show_users_table_when_the_user_has_no_permission(): void
    {
        $moderatorRole = Role::findByName('moderator');
        $moderatorRole->revokePermissionTo('admin users');
        $response = $this->get(route('admin-area.users'));
        $response->assertForbidden()->assertDontSeeLivewire('admin-area-users');
    }

    /**
     * @test
     */
    public function it_shows_users_in_the_table(): void
    {
        $this->assertDatabaseCount('users', 2);

        Livewire::test(AdminAreaUsers::class)
            ->call('render')
            ->assertSee('Rolf Liebermann')
            ->assertSee('Rolfi')
            ->assertSee('rolf.liebermann@example.com')
            ->assertSeeHtml('<i class="fas fa-trash"></i>');
    }

    /**
     * @test
     */
    public function it_allows_to_search_for_users(): void
    {
        // Global search:
        Livewire::test(AdminAreaUsers::class)
            ->call('render')
            ->assertSee('Rolf Liebermann')
            ->set('globalSearch', '123')
            ->assertDontSee('Rolf Liebermann')
            ->set('globalSearch', 'mann')
            ->assertSee('Rolf Liebermann');

        // Search by name:
        Livewire::test(AdminAreaUsers::class)
            ->call('render')
            ->set('searchName', 'olf')
            ->assertSee('Rolf Liebermann')
            ->set('searchName', '123')
            ->assertDontSee('Rolf Liebermann')
            ->set('searchName', 'olf')
            ->assertSee('Rolf Liebermann');

        // Search by username:
        Livewire::test(AdminAreaUsers::class)
            ->call('render')
            ->set('searchUsername', 'Liebermann')
            ->assertDontSee('Rolf Liebermann')
            ->set('searchUsername', 'Rolfi')
            ->assertSee('Rolf Liebermann');

        // Search by email:
        Livewire::test(AdminAreaUsers::class)
            ->call('render')
            ->set('searchEmail', 'abc@example.com')
            ->assertDontSee('Rolf Liebermann')
            ->set('searchEmail', '@example.com')
            ->assertSee('Rolf Liebermann');

        // Combined search:
        Livewire::test(AdminAreaUsers::class)
            ->call('render')
            ->set('searchEmail', '@example.com')
            ->assertSee('Rolf Liebermann')
            ->set('searchName', 'foo')
            ->assertDontSee('Rolf Liebermann')
            ->set('searchName', 'Rolf')
            ->assertSee('Rolf Liebermann');
    }

    /**
     * @test
     */
    public function it_allows_to_order_users(): void
    {
        $this->authUser->name = 'Anna';
        $this->authUser->email = 'aaa@bbb.com';
        $this->authUser->save();

        Livewire::test(AdminAreaUsers::class)
            ->call('render')
            ->set('sortBy', 'name')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder(['Anna', 'Rolf Liebermann'])
            ->set('sortDirection', 'desc')
            ->assertSeeInOrder(['Rolf Liebermann', 'Anna'])
            ->set('sortBy', 'email')
            ->set('sortDirection', 'asc')
            ->assertSeeInOrder(['aaa@bbb.com', 'rolf.liebermann@example.com'])
            ->set('sortDirection', 'desc')
            ->assertSeeInOrder(['rolf.liebermann@example.com', 'aaa@bbb.com']);
    }

    /**
     * @test
     */
    public function it_shows_deleted_users_when_table_view_is_changed(): void
    {
        Livewire::test(AdminAreaUsers::class)
            ->call('render')
            ->assertSee('Rolf Liebermann')
            ->set('showDeletedElements', true)
            ->assertDontSee('Rolf Liebermann');

        $this->assertDatabaseHas('users', [
            'name' => 'Rolf Liebermann',
            'deleted_at' => null,
        ]);

        $this->testUser->deleted_at = '2021-04-01 15:36:41';
        $this->testUser->save();

        $this->assertDatabaseHas('users', [
            'name' => 'Rolf Liebermann',
            'deleted_at' => '2021-04-01 15:36:41',
        ]);

        Livewire::test(AdminAreaUsers::class)
            ->call('render')
            ->assertDontSee('Rolf Liebermann')
            ->set('showDeletedElements', true)
            ->assertSee('Rolf Liebermann');
    }

    /**
     * @test
     */
    public function it_allows_to_delete_and_restore_users(): void
    {
        $this->assertDatabaseHas('users', [
            'name' => 'Rolf Liebermann',
            'deleted_at' => null,
        ]);

        $testUserId = $this->testUser->id;

        // Delete user:
        Livewire::test(AdminAreaUsers::class)
            ->call('render')
            ->call('selectModelInstance', $testUserId, 'delete')
            ->assertDispatchedBrowserEvent('openDeleteModelInstanceModal')
            ->assertSee('Delete this User')
            ->assertSee('Name: Rolf Liebermann')
            ->assertSee('Yes, Delete')
            ->call('deleteModelInstance')
            ->assertDispatchedBrowserEvent('closeDeleteModelInstanceModal')
            ->assertDontSee('Rolf Liebermann')
            ->set('showDeletedElements', true)
            ->assertSee('Rolf Liebermann');

        $this->assertDatabaseMissing('users', [
            'name' => 'Rolf Liebermann',
            'deleted_at' => null,
        ]);

        // Restore user:
        Livewire::test(AdminAreaUsers::class)
            ->set('showDeletedElements', true)
            ->assertSee('Rolf Liebermann')
            ->assertSeeHtml('<i class="fas fa-trash-restore"></i>')
            ->call('selectModelInstance', $testUserId, 'restore')
            ->assertSee('Restore this User')
            ->assertSee('Name: Rolf Liebermann')
            ->assertSee('Yes, Restore')
            ->call('restoreModelInstance')
            ->assertDispatchedBrowserEvent('closeRestoreModelInstanceModal')
            ->assertDontSee('Rolf Liebermann')
            ->set('showDeletedElements', false)
            ->assertSee('Rolf Liebermann');

        $this->assertDatabaseHas('users', [
            'name' => 'Rolf Liebermann',
            'deleted_at' => null,
        ]);
    }

    /**
     * @test
     */
    public function it_allows_to_edit_user_roles(): void
    {
        $testUserId = $this->testUser->id;

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => Role::all()->where('name', 'user')->first()->id,
            'model_id' => $testUserId,
        ]);

        $this->assertDatabaseMissing('model_has_roles', [
            'role_id' => Role::all()->where('name', 'moderator')->first()->id,
            'model_id' => $testUserId,
        ]);

        Livewire::test(AdminAreaUsers::class)
            ->call('render')
            ->call('selectModelInstance', $testUserId, 'update')
            ->assertDispatchedBrowserEvent('openUpdateModelInstanceModal')
            ->assertSee('Edit user roles of Rolfi')
            ->set('roles', ['moderator' => true, 'user' => false])
            ->call('updateRoles')
            ->assertDispatchedBrowserEvent('closeUpdateModelInstanceModal');

        $this->assertDatabaseMissing('model_has_roles', [
            'role_id' => Role::all()->where('name', 'user')->first()->id,
            'model_id' => $testUserId,
        ]);

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => Role::all()->where('name', 'moderator')->first()->id,
            'model_id' => $testUserId,
        ]);
    }

    /**
     * @test
     */
    public function it_disallows_to_assign_or_revoke_the_superadmin_user_role_for_users_not_in_role_superadmin(): void
    {
        $testUserId = $this->testUser->id;

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => Role::all()->where('name', 'user')->first()->id,
            'model_id' => $testUserId,
        ]);

        $this->assertDatabaseMissing('model_has_roles', [
            'role_id' => Role::all()->where('name', 'super-admin')->first()->id,
            'model_id' => $testUserId,
        ]);

        Livewire::test(AdminAreaUsers::class)
            ->call('render')
            ->call('selectModelInstance', $testUserId, 'update')
            ->assertDispatchedBrowserEvent('openUpdateModelInstanceModal')
            ->assertSee('Edit user roles of Rolfi')
            ->assertSee('You are not allowed to assign or revoke this role')
            ->set('roles', ['super-admin' => true, 'user' => true])
            ->call('updateRoles');

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => Role::all()->where('name', 'user')->first()->id,
            'model_id' => $testUserId,
        ]);

        $this->assertDatabaseMissing('model_has_roles', [
            'role_id' => Role::all()->where('name', 'super-admin')->first()->id,
            'model_id' => $testUserId,
        ]);
    }
}
