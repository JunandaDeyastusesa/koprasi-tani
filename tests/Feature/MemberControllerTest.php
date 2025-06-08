<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class MemberControllerTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsAdmin()
    {
        $adminRole = Role::factory()->create(['nama' => 'Admin']);
        $admin = User::factory()->create();
        $admin->roles()->attach($adminRole->id);
        $this->actingAs($admin);
    }

    public function test_index_returns_members()
    {
        $this->actingAsAdmin();

        $memberRole = Role::factory()->create(['nama' => 'Member']);
        $member = User::factory()->create();
        $member->roles()->attach($memberRole->id);

        $response = $this->get('/members');
        $response->assertStatus(200);
        $response->assertViewIs('member.index');
        $response->assertViewHas('users', fn($users) => $users->contains($member));
    }

    public function test_index_returns_404_when_no_members()
    {
        $this->actingAsAdmin();
        Role::factory()->create(['nama' => 'Member']);

        $response = $this->get('/members');
        $response->assertStatus(404);
        $response->assertJson(['message' => 'Tidak ada member ditemukan']);
    }

    public function test_create_member_view()
    {
        $this->actingAsAdmin();

        $response = $this->get('/members/create');
        $response->assertStatus(200);
        $response->assertViewIs('member.create');
    }

    public function test_store_creates_new_member()
    {
        $this->actingAsAdmin();
        Role::factory()->create(['nama' => 'Member']);

        $response = $this->post('/members', [
            'name' => 'Test Member',
            'email' => 'testmember@example.com',
            'username' => 'testmember',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'Member',
        ]);

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('users', ['email' => 'testmember@example.com']);
    }

    public function test_store_with_invalid_role_does_not_attach_role()
    {
        $this->actingAsAdmin();
        Role::factory()->create(['nama' => 'Admin']);

        $response = $this->post('/members', [
            'name' => 'Another User',
            'email' => 'another@example.com',
            'username' => 'anotheruser',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'InvalidRole', // tidak valid
        ]);

        $response->assertSessionHasErrors('role');
    }

    public function test_edit_member_view()
    {
        $this->actingAsAdmin();
        $user = User::factory()->create();

        $response = $this->get("/members/{$user->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('member.edit');
        $response->assertViewHas('user', $user);
    }

    public function test_update_changes_member_data_with_password()
    {
        $this->actingAsAdmin();
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->put("/members/{$user->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'username' => 'updatedusername',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }

    public function test_update_changes_member_data_without_password()
    {
        $this->actingAsAdmin();

        $member = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'username' => 'oldusername',
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->put("/members/{$member->id}", [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'username' => 'newusername',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('users', ['email' => 'new@example.com', 'name' => 'New Name']);
        $this->assertTrue(Hash::check('oldpassword', $member->fresh()->password));
    }

    public function test_destroy_deletes_member_with_member_role()
    {
        $this->actingAsAdmin();
        $memberRole = Role::factory()->create(['nama' => 'Member']);
        $member = User::factory()->create();
        $member->roles()->attach($memberRole->id);

        $response = $this->delete("/members/{$member->id}");
        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseMissing('users', ['id' => $member->id]);
    }

    public function test_destroy_deletes_user_without_member_role()
    {
        $this->actingAsAdmin();
        $user = User::factory()->create(); // tanpa role "Member"

        $response = $this->delete("/members/{$user->id}");
        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_show_method_placeholder()
    {
        $this->actingAsAdmin();
        $user = User::factory()->create();

        // karena kosong, tetap bisa dipanggil untuk coverage
        $response = $this->get("/members/{$user->id}");
        $response->assertStatus(200); // Laravel akan return 200 dengan view kosong/default
    }
}
