<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Inventaris;
use App\Models\Transaksi;

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

    public function test_create_page_returns_success()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/inventaris/create');
        $response->assertStatus(200);
        $response->assertViewIs('inventaris.create');
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

    public function test_store_validation_fails()
    {
        $user = User::factory()->create();

        $data = []; // data kosong harus gagal validasi

        $response = $this->actingAs($user)->post('/inventaris', $data);
        $response->assertSessionHasErrors(['nama', 'kategori', 'harga_jual', 'harga_beli', 'jumlah', 'deskripsi']);
    }

    public function test_show_inventaris()
    {
        $user = User::factory()->create();
        $item = Inventaris::factory()->create();

        $response = $this->actingAs($user)->get("/inventaris/{$item->id}");
        $response->assertStatus(200);
        $response->assertViewIs('inventaris.show');
    }

    public function test_show_inventaris_fails_not_found()
{
    $user = User::factory()->create();

    $invalidId = 9999; // id yang kemungkinan tidak ada di database

    $response = $this->actingAs($user)->get("/inventaris/{$invalidId}");
    $response->assertStatus(404);
}


    public function test_edit_page_returns_success()
    {
        $user = User::factory()->create();
        $item = Inventaris::factory()->create();

        $response = $this->actingAs($user)->get("/inventaris/{$item->id}/edit");
        $response->assertStatus(200);
        $response->assertViewIs('inventaris.edit');
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

    public function test_update_validation_fails()
    {
        $user = User::factory()->create();
        $item = Inventaris::factory()->create();

        $data = [
            'nama' => '',
            'kategori' => '',
            'harga_jual' => 0,
            'harga_beli' => 0,
            'jumlah' => 0,
            'deskripsi' => '',
        ];

        $response = $this->actingAs($user)->put("/inventaris/{$item->id}", $data);
        $response->assertSessionHasErrors(['nama', 'kategori', 'harga_jual', 'harga_beli', 'jumlah', 'deskripsi']);
    }

    public function test_delete_inventaris()
    {
        $user = User::factory()->create();
        $item = Inventaris::factory()->create();

        $response = $this->actingAs($user)->delete("/inventaris/{$item->id}");
        $response->assertRedirect('/inventaris');

        $this->assertDatabaseMissing('inventaries', ['id' => $item->id]);
    }
     public function test_inventari_has_many_transaksis()
    {
        // Arrange: buat 1 inventari
        $inventari = Inventaris::factory()->create();

        // Buat beberapa transaksi yang terkait dengan inventari tersebut
        $transaksi1 = Transaksi::factory()->create(['inventari_id' => $inventari->id]);
        $transaksi2 = Transaksi::factory()->create(['inventari_id' => $inventari->id]);

        // Act: ambil relasi dari model
        $transaksis = $inventari->transaksis;

        // Assert: pastikan relasi berjalan benar
        $this->assertCount(2, $transaksis);
        $this->assertTrue($transaksis->contains($transaksi1));
        $this->assertTrue($transaksis->contains($transaksi2));
    }
}
