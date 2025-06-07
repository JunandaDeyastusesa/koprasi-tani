<?php

namespace Tests\Feature;

use App\Models\Mitra;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MitraControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function index_shows_all_mitras()
    {
        $user = \App\Models\User::factory()->create();

        // Buat atau ambil role 'admin'
        $adminRole = \App\Models\Role::firstOrCreate(['nama' => 'admin']);

        // Assign role ke user
        $user->roles()->attach($adminRole->id);

        // Login sebagai admin
        $this->actingAs($user);

        // Akses route yang dilindungi
        $response = $this->get(route('mitras.index'));


        Mitra::factory()->count(3)->create();

        $response->assertStatus(200);
        $response->assertViewIs('mitra.index');
        $response->assertViewHas('mitras');
    }

    /** @test */
    public function create_shows_create_form()
    {
                $user = \App\Models\User::factory()->create();

        // Buat atau ambil role 'admin'
        $adminRole = \App\Models\Role::firstOrCreate(['nama' => 'admin']);

        // Assign role ke user
        $user->roles()->attach($adminRole->id);

        // Login sebagai admin
        $this->actingAs($user);

        // Akses route yang dilindungi
        $response = $this->get(route('mitras.index'));
        $response = $this->get(route('mitras.create'));

        $response->assertStatus(200);
        $response->assertViewIs('mitra.create');
    }

    /** @test */
    public function store_saves_new_mitra_and_redirects()
    {
                $user = \App\Models\User::factory()->create();

        // Buat atau ambil role 'admin'
        $adminRole = \App\Models\Role::firstOrCreate(['nama' => 'admin']);

        // Assign role ke user
        $user->roles()->attach($adminRole->id);

        // Login sebagai admin
        $this->actingAs($user);

        // Akses route yang dilindungi
        $response = $this->get(route('mitras.index'));
        $data = [
            'nama' => 'Mitra Test',
            'email' => 'mitratest@example.com',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Test No 1',
        ];

        $response = $this->post(route('mitras.store'), $data);

        $response->assertRedirect(route('mitras.index'));
        $this->assertDatabaseHas('mitras', ['email' => 'mitratest@example.com']);
    }

    /** @test */
    public function store_fails_with_invalid_data()
    {
                $user = \App\Models\User::factory()->create();

        // Buat atau ambil role 'admin'
        $adminRole = \App\Models\Role::firstOrCreate(['nama' => 'admin']);

        // Assign role ke user
        $user->roles()->attach($adminRole->id);

        // Login sebagai admin
        $this->actingAs($user);

        // Akses route yang dilindungi
        $response = $this->get(route('mitras.index'));
        $data = [
            'nama' => '', // nama kosong
            'email' => 'not-an-email',
            'no_hp' => '',
            'alamat' => '',
        ];

        $response = $this->post(route('mitras.store'), $data);

        $response->assertSessionHasErrors(['nama', 'email', 'no_hp', 'alamat']);
    }

    /** @test */
    public function edit_shows_edit_form()
    {
                $user = \App\Models\User::factory()->create();

        // Buat atau ambil role 'admin'
        $adminRole = \App\Models\Role::firstOrCreate(['nama' => 'admin']);

        // Assign role ke user
        $user->roles()->attach($adminRole->id);

        // Login sebagai admin
        $this->actingAs($user);

        // Akses route yang dilindungi
        $response = $this->get(route('mitras.index'));
        $mitra = Mitra::factory()->create();

        $response = $this->get(route('mitras.edit', $mitra->id));

        $response->assertStatus(200);
        $response->assertViewIs('mitra.edit');
        $response->assertViewHas('mitra', $mitra);
    }

    /** @test */
    public function update_changes_mitra_data_and_redirects()
    {
                $user = \App\Models\User::factory()->create();

        // Buat atau ambil role 'admin'
        $adminRole = \App\Models\Role::firstOrCreate(['nama' => 'admin']);

        // Assign role ke user
        $user->roles()->attach($adminRole->id);

        // Login sebagai admin
        $this->actingAs($user);

        // Akses route yang dilindungi
        $response = $this->get(route('mitras.index'));
        $mitra = Mitra::factory()->create();

        $data = [
            'nama' => 'Updated Nama',
            'email' => 'updatedemail@example.com',
            'no_hp' => '089876543210',
            'alamat' => 'Jl. Updated No 2',
        ];

        $response = $this->put(route('mitras.update', $mitra->id), $data);

        $response->assertRedirect(route('mitras.index'));
        $this->assertDatabaseHas('mitras', [
            'id' => $mitra->id,
            'nama' => 'Updated Nama',
            'email' => 'updatedemail@example.com',
        ]);
    }

    /** @test */
    public function update_fails_with_invalid_data()
    {
                $user = \App\Models\User::factory()->create();

        // Buat atau ambil role 'admin'
        $adminRole = \App\Models\Role::firstOrCreate(['nama' => 'admin']);

        // Assign role ke user
        $user->roles()->attach($adminRole->id);

        // Login sebagai admin
        $this->actingAs($user);

        // Akses route yang dilindungi
        $response = $this->get(route('mitras.index'));
        $mitra = Mitra::factory()->create();

        $data = [
            'nama' => '',
            'email' => 'not-an-email',
            'no_hp' => '',
            'alamat' => '',
        ];

        $response = $this->put(route('mitras.update', $mitra->id), $data);

        $response->assertSessionHasErrors(['nama', 'email', 'no_hp', 'alamat']);
    }

    /** @test */
    public function destroy_deletes_mitra_and_redirects()
    {
                $user = \App\Models\User::factory()->create();

        // Buat atau ambil role 'admin'
        $adminRole = \App\Models\Role::firstOrCreate(['nama' => 'admin']);

        // Assign role ke user
        $user->roles()->attach($adminRole->id);

        // Login sebagai admin
        $this->actingAs($user);

        // Akses route yang dilindungi
        $response = $this->get(route('mitras.index'));
        $mitra = Mitra::factory()->create();

        $response = $this->delete(route('mitras.destroy', $mitra->id));

        $response->assertRedirect(route('mitras.index'));
        $this->assertDatabaseMissing('mitras', ['id' => $mitra->id]);
    }
}
