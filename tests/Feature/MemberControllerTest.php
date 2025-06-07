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

    protected function setUp(): void
    {
        parent::setUp();

        // Buat role Member di database
        Role::factory()->create(['nama' => 'Member']);
    }

    public function test_index_shows_members()
    {
        $roleMember = Role::where('nama', 'Member')->first();

        // Buat 3 user dan attach role Member
        $users = User::factory()->count(3)->create();
        foreach ($users as $user) {
            $user->roles()->attach($roleMember->id);
        }

        $response = $this->get(route('members.index'));

        $response->assertStatus(200);
        $response->assertViewIs('member.index');
        $response->assertViewHas('users', function ($viewUsers) use ($users) {
            return $viewUsers->count() === 3;
        });
    }

    public function test_index_returns_404_if_no_member()
    {
        $response = $this->get(route('members.index'));

        $response->assertStatus(404);
        $response->assertJson(['message' => 'Tidak ada member ditemukan']);
    }

    public function test_store_creates_member()
    {
        $roleMember = Role::where('nama', 'Member')->first();

        $response = $this->post(route('members.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'username' => 'john123',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            'role' => 'Member',
        ]);

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'username' => 'john123',
            'name' => 'John Doe',
        ]);

        $user = User::where('email', 'john@example.com')->first();
        $this->assertTrue($user->roles()->where('nama', 'Member')->exists());
    }

    public function test_update_member()
    {
        $roleMember = Role::where('nama', 'Member')->first();
        $user = User::factory()->create([
            'email' => 'oldemail@example.com',
            'username' => 'oldusername',
            'password' => Hash::make('oldpassword'),
        ]);
        $user->roles()->attach($roleMember->id);

        $response = $this->put(route('members.update', $user->id), [
            'name' => 'New Name',
            'email' => 'newemail@example.com',
            'username' => 'newusername',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('members.index'));

        $user->refresh();

        $this->assertEquals('New Name', $user->name);
        $this->assertEquals('newemail@example.com', $user->email);
        $this->assertEquals('newusername', $user->username);
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    public function test_destroy_deletes_member_and_detaches_role()
    {
        $roleMember = Role::where('nama', 'Member')->first();
        $user = User::factory()->create();
        $user->roles()->attach($roleMember->id);

        $response = $this->delete(route('members.destroy', $user->id));

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('user_roles', ['user_id' => $user->id]);
    }
}
