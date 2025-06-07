<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin dapat mengakses halaman index user.
     */
    public function test_admin_can_access_user_index()
    {
        $user = User::factory()->create();

        // Buat role admin dan attach ke user
        $adminRole = Role::firstOrCreate(['nama' => 'admin']);
        $user->roles()->attach($adminRole->id);

        $this->actingAs($user);

        $response = $this->get(route('user.index'));

        $response->assertStatus(200);
        $response->assertViewIs('user.index');
    }

    /**
     * Test admin dapat membuat user baru.
     */
    public function test_admin_can_store_user()
    {
        $user = User::factory()->create();
        $adminRole = Role::firstOrCreate(['nama' => 'admin']);
        $user->roles()->attach($adminRole->id);
        $this->actingAs($user);

        $data = [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123', // biasanya harus di-hash di controller
            'password_confirmation' => 'password123',
        ];

        $response = $this->post(route('user.store'), $data);

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'email' => 'testuser@example.com',
            'name' => 'Test User',
        ]);
    }

    /**
     * Test admin dapat melihat detail user.
     */
    public function test_admin_can_show_user()
    {
        $user = User::factory()->create();
        $adminRole = Role::firstOrCreate(['nama' => 'admin']);
        $user->roles()->attach($adminRole->id);
        $this->actingAs($user);

        $targetUser = User::factory()->create();

        $response = $this->get(route('user.show', $targetUser->id));

        $response->assertStatus(200);
        $response->assertViewIs('user.show');
        $response->assertViewHas('user');
    }

    /**
     * Test admin dapat mengupdate data user.
     */
    public function test_admin_can_update_user()
    {
        $user = User::factory()->create();
        $adminRole = Role::firstOrCreate(['nama' => 'admin']);
        $user->roles()->attach($adminRole->id);
        $this->actingAs($user);

        $targetUser = User::factory()->create();

        $data = [
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ];

        $response = $this->put(route('user.update', $targetUser->id), $data);

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'id' => $targetUser->id,
            'name' => 'Updated Name',
            'email' => 'updatedemail@example.com',
        ]);
    }

    /**
     * Test admin dapat menghapus user.
     */
    public function test_admin_can_delete_user()
    {
        $user = User::factory()->create();
        $adminRole = Role::firstOrCreate(['nama' => 'admin']);
        $user->roles()->attach($adminRole->id);
        $this->actingAs($user);

        $targetUser = User::factory()->create();

        $response = $this->delete(route('user.destroy', $targetUser->id));

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('success');

        $this->assertDeleted($targetUser);
    }
}
