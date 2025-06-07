<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Transaksi;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Inventaris;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransaksiControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test menampilkan halaman index transaksi.
     */
    private function createAdminUser()
    {
        $user = User::factory()->create();
        $adminRole = \App\Models\Role::firstOrCreate(['nama' => 'admin']);
        $user->roles()->attach($adminRole->id);
        return $user;
    }

    public function test_admin_can_access_transaksi_index()
    {
        $user = $this->createAdminUser();
        $this->actingAs($user);

        // Akses route yang dilindungi
        $response = $this->get(route('transaksi.index'));

        $response->assertStatus(200);
        $response->assertViewIs('transaksi.index');
    }



    /**
     * Test menyimpan transaksi Penjualan (status: Penjualan).
     */
    public function test_store_penjualan_transaksi_success()
    {
        $user = $this->createAdminUser();
        $this->actingAs($user);


        // Akses route yang dilindungi
        $response = $this->get(route('transaksi.index'));
        // Buat data mitra, user, inventaris
        $mitra = Mitra::factory()->create();
        $user = User::factory()->create();
        $inventaris = Inventaris::factory()->create([
            'jumlah' => 10, // stok awal cukup
        ]);

        $data = [
            'mitra_id' => $mitra->id,
            'user_id' => $user->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 5,
            'total_harga' => 100000,
            'tgl_transaksi' => now()->toDateString(),
            'status' => 'Penjualan',
        ];

        $response = $this->post(route('transaksi.store'), $data);

        // Pastikan redirect ke index dengan session success
        $response->assertRedirect(route('transaksi.index'));
        $response->assertSessionHas('success');

        // Cek data transaksi ada di DB
        $this->assertDatabaseHas('transaksis', [
            'mitra_id' => $mitra->id,
            'user_id' => $user->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 5,
            'total_harga' => 100000,
            'status' => 'Penjualan',
        ]);

        // Cek stok inventaris berkurang
        $inventaris->refresh();
        $this->assertEquals(5, $inventaris->jumlah);
    }

    /**
     * Test menyimpan transaksi Pembelian (status: Pembelian).
     */
    public function test_store_pembelian_transaksi_success()
    {
        $user = $this->createAdminUser();
        $this->actingAs($user);


        // Akses route yang dilindungi
        $response = $this->get(route('transaksi.index'));
        $mitra = Mitra::factory()->create();
        $user = User::factory()->create();
        $inventaris = Inventaris::factory()->create([
            'jumlah' => 10,
        ]);

        $data = [
            'mitra_id' => $mitra->id,
            'user_id' => $user->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 7,
            'total_harga' => 70000,
            'tgl_transaksi' => now()->toDateString(),
            'status' => 'Pembelian',
        ];

        $response = $this->post(route('transaksi.store'), $data);

        $response->assertRedirect(route('transaksi.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('transaksis', [
            'mitra_id' => $mitra->id,
            'user_id' => $user->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 7,
            'total_harga' => 70000,
            'status' => 'Pembelian',
        ]);

        $inventaris->refresh();
        $this->assertEquals(17, $inventaris->jumlah);
    }

    /**
     * Test gagal menyimpan jika stok kurang pada Penjualan.
     */
    public function test_store_penjualan_stok_kurang_fails()
    {
        $user = $this->createAdminUser();
        $this->actingAs($user);


        // Akses route yang dilindungi
        $response = $this->get(route('transaksi.index'));
        $inventaris = Inventaris::factory()->create(['jumlah' => 3]);

        $data = [
            'mitra_id' => null,
            'user_id' => null,
            'inventari_id' => $inventaris->id,
            'jumlah' => 5, // lebih dari stok
            'total_harga' => 50000,
            'tgl_transaksi' => now()->toDateString(),
            'status' => 'Penjualan',
        ];

        $response = $this->post(route('transaksi.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Stok tidak mencukupi untuk transaksi ini.');

        $this->assertDatabaseMissing('transaksis', [
            'inventari_id' => $inventaris->id,
            'jumlah' => 5,
        ]);
    }

    /**
     * Test menampilkan detail transaksi.
     */
    public function test_show_transaksi()
    {
        $user = $this->createAdminUser();
        $this->actingAs($user);


        // Akses route yang dilindungi
        $response = $this->get(route('transaksi.index'));
        $transaksi = Transaksi::factory()->create();

        $response = $this->get(route('transaksi.show', $transaksi->id));

        $response->assertStatus(200);
        $response->assertViewIs('transaksi.show');
        $response->assertViewHas(['pageTitle', 'transaksi', 'mitra', 'user', 'inventari']);
    }

    /**
     * Test update transaksi.
     */
    public function test_update_transaksi_success()
    {
        $user = $this->createAdminUser();
        $this->actingAs($user);

        // Akses route yang dilindungi
        $response = $this->get(route('transaksi.index'));
        $transaksi = Transaksi::factory()->create();
        $mitra = Mitra::factory()->create();
        $inventaris = Inventaris::factory()->create();

        $data = [
            'mitra_id' => $mitra->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 10,
            'total_harga' => 100000,
            'tgl_transaksi' => now()->toDateString(),
            'status' => 'Pembelian',
        ];

        $response = $this->put(route('transaksi.update', $transaksi->id), $data);

        $response->assertRedirect(route('transaksi.index'));

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('transaksis', [
            'id' => $transaksi->id,
            'mitra_id' => $mitra->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 10,
            'total_harga' => 100000,
            'status' => 'Pembelian',
        ]);
    }

    /**
     * Test delete transaksi.
     */
    public function test_destroy_transaksi()
    {
        $user = $this->createAdminUser();
        $this->actingAs($user);
        // Akses route yang dilindungi
        $response = $this->get(route('transaksi.index'));
        $transaksi = Transaksi::factory()->create();

        $response = $this->delete(route('transaksi.destroy', $transaksi->id));

        $response->assertRedirect(route('transaksi.index'));
        $response->assertSessionHas('success');

        $this->assertDeleted($transaksi);
    }
}
