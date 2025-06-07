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
        $response->assertViewHas('users', function ($users) use ($member) {
            return $users->contains($member);
        });
    }

    public function test_index_returns_404_when_no_members()
    {
        $this->actingAsAdmin();

        Role::factory()->create(['nama' => 'Member']);

        $response = $this->get('/members');
        $response->assertStatus(404);
        $response->assertJson(['message' => 'Tidak ada member ditemukan']);
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

    public function test_update_changes_member_data()
    {
        $this->actingAsAdmin();

        $memberRole = Role::factory()->create(['nama' => 'Member']);
        $member = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
            'username' => 'oldusername',
        ]);
        $member->roles()->attach($memberRole->id);

        $response = $this->put("/members/{$member->id}", [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'username' => 'newusername',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('users', ['email' => 'new@example.com', 'name' => 'New Name']);
    }

    public function test_destroy_deletes_member()
    {
        $this->actingAsAdmin();

        $memberRole = Role::factory()->create(['nama' => 'Member']);
        $member = User::factory()->create();
        $member->roles()->attach($memberRole->id);

        $response = $this->delete("/members/{$member->id}");
        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseMissing('users', ['id' => $member->id]);
    }
}
