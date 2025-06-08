<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Mitra;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MitraControllerTest extends TestCase
{
    use RefreshDatabase;

    private function authenticate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_mitra_index_displays_data()
    {
        $this->authenticate();

        $mitra = Mitra::factory()->create();

        $response = $this->get(route('mitras.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Data Mitra');
        $response->assertSeeText($mitra->nama);
    }

    public function test_create_mitra_page_is_accessible()
    {
        $this->authenticate();

        $response = $this->get(route('mitras.create'));
        $response->assertStatus(200);
        $response->assertSeeText('Tambah Mitra');
    }

    public function test_store_mitra_with_valid_data()
    {
        $this->authenticate();

        $data = [
            'nama' => 'Mitra Baru',
            'email' => 'mitra@example.com',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Contoh Alamat',
        ];

        $response = $this->post(route('mitras.store'), $data);

        $response->assertRedirect(route('mitras.index'));
        $this->assertDatabaseHas('mitras', ['email' => 'mitra@example.com']);
    }

    public function test_store_mitra_with_invalid_data_should_fail()
    {
        $this->authenticate();

        $data = [
            'nama' => '', // required
            'email' => 'not-an-email',
            'no_hp' => '',
            'alamat' => '',
        ];

        $response = $this->post(route('mitras.store'), $data);

        $response->assertSessionHasErrors(['nama', 'email', 'no_hp', 'alamat']);
    }

    public function test_edit_mitra_page_shows_data()
    {
        $this->authenticate();

        $mitra = Mitra::factory()->create();

        $response = $this->get(route('mitras.edit', $mitra->id));

        $response->assertStatus(200);
        $response->assertSeeText('Edit Mitra');
        $response->assertSee($mitra->nama);
    }

    public function test_update_mitra_with_valid_data()
    {
        $this->authenticate();

        $mitra = Mitra::factory()->create();

        $updatedData = [
            'nama' => 'Updated Mitra',
            'email' => 'updated@example.com',
            'no_hp' => '0899999999',
            'alamat' => 'Alamat Baru',
        ];

        $response = $this->put(route('mitras.update', $mitra->id), $updatedData);

        $response->assertRedirect(route('mitras.index'));
        $this->assertDatabaseHas('mitras', ['email' => 'updated@example.com']);
    }

    public function test_update_mitra_with_invalid_data_should_fail()
    {
        $this->authenticate();

        $mitra = Mitra::factory()->create();

        $invalidData = [
            'nama' => '',
            'email' => 'salah-email',
            'no_hp' => '',
            'alamat' => '',
        ];

        $response = $this->put(route('mitras.update', $mitra->id), $invalidData);

        $response->assertSessionHasErrors(['nama', 'email', 'no_hp', 'alamat']);
    }

    public function test_delete_mitra()
    {
        $this->authenticate();

        $mitra = Mitra::factory()->create();

        $response = $this->delete(route('mitras.destroy', $mitra->id));

        $response->assertRedirect(route('mitras.index'));
        $this->assertDatabaseMissing('mitras', ['id' => $mitra->id]);
    }

    public function test_edit_nonexistent_mitra_should_throw_404()
    {
        $this->authenticate();

        $response = $this->get(route('mitras.edit', 999));
        $response->assertStatus(404);
    }

    public function test_update_nonexistent_mitra_should_throw_404()
    {
        $this->authenticate();

        $data = [
            'nama' => 'Dummy',
            'email' => 'dummy@example.com',
            'no_hp' => '0811111111',
            'alamat' => 'Jl. Dummy',
        ];

        $response = $this->put(route('mitras.update', 999), $data);
        $response->assertStatus(404);
    }

    public function test_delete_nonexistent_mitra_should_throw_404()
    {
        $this->authenticate();

        $response = $this->delete(route('mitras.destroy', 999));
        $response->assertStatus(404);
    }
}
