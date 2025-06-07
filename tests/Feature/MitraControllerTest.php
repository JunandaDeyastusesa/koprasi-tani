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

    public function test_update_mitra()
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

    public function test_delete_mitra()
    {
        $this->authenticate();

        $mitra = Mitra::factory()->create();

        $response = $this->delete(route('mitras.destroy', $mitra->id));

        $response->assertRedirect(route('mitras.index'));
        $this->assertDatabaseMissing('mitras', ['id' => $mitra->id]);
    }
}