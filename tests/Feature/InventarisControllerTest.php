<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Inventaris;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventarisControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate');
    }

    public function test_index_returns_success()
    {
        $user = User::factory()->create();
        Inventaris::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/inventaris');
        $response->assertStatus(200);
        $response->assertViewIs('inventaris.index');
    }

    public function test_store_valid_data()
    {
        $user = User::factory()->create();

        $data = [
            'nama' => 'Laptop',
            'kategori' => 'Elektronik',
            'harga_jual' => 5000000,
            'harga_beli' => 4500000,
            'jumlah' => 10,
            'deskripsi' => 'Laptop baru 2025',
        ];

        $response = $this->actingAs($user)->post('/inventaris', $data);
        $response->assertRedirect('/inventaris');
        $this->assertDatabaseHas('inventaries', ['nama' => 'Laptop']);
    }

    public function test_show_inventaris()
    {
        $user = User::factory()->create();
        $item = Inventaris::factory()->create();

        $response = $this->actingAs($user)->get("/inventaris/{$item->id}");
        $response->assertStatus(200);
        $response->assertViewIs('inventaris.show');
    }

    public function test_update_inventaris()
    {
        $user = User::factory()->create();
        $item = Inventaris::factory()->create();

        $data = [
            'nama' => 'Updated Name',
            'kategori' => 'Updated Kategori',
            'harga_jual' => 600000,
            'harga_beli' => 500000,
            'jumlah' => 5,
            'deskripsi' => 'Updated Deskripsi',
        ];

        $response = $this->actingAs($user)->put("/inventaris/{$item->id}", $data);
        $response->assertRedirect('/inventaris');

        $this->assertDatabaseHas('inventaries', ['nama' => 'Updated Name']);
    }

    public function test_delete_inventaris()
    {
        
        $user = User::factory()->create();
        $item = Inventaris::factory()->create();

        $response = $this->actingAs($user)->delete("/inventaris/{$item->id}");
        $response->assertRedirect('/inventaris');

        $this->assertDatabaseMissing('inventaries', ['id' => $item->id]);
    }
}