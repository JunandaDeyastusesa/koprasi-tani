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

    public function test_index_displays_data()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('transaksi.index'));

        $response->assertStatus(200);
        $response->assertViewIs('transaksi.index');
        $response->assertViewHasAll(['pageTitle', 'transaksis', 'mitras', 'inventaris']);
    }

    public function test_viewTransaksiMember_shows_only_user_transactions()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $transaksi1 = Transaksi::factory()->create(['user_id' => $user->id]);
        $transaksi2 = Transaksi::factory()->create();

        $response = $this->get(route('viewTransaksiMember'));

        $response->assertStatus(200);
        $response->assertViewHas('transaksis', function ($transaksis) use ($user, $transaksi1, $transaksi2) {
            return $transaksis->contains($transaksi1) && !$transaksis->contains($transaksi2);
        });
    }

    public function test_create_displays_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('transaksi.create'));

        $response->assertStatus(200);
        $response->assertViewIs('transaksi.create');
        $response->assertViewHasAll(['pageTitle', 'mitras', 'inventaris', 'user']);
    }

    // ================================
    // TEST STORE
    // ================================

    public function test_store_penjualan_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $mitra = Mitra::factory()->create();
        $inventaris = Inventaris::factory()->create(['jumlah' => 10]);

        $data = [
            'mitra_id' => $mitra->id,
            'user_id' => $user->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 5,
            'total_harga' => 50000,
            'tgl_transaksi' => now()->toDateString(),
            'status' => 'Penjualan',
        ];

        $response = $this->post(route('transaksi.store'), $data);

        $response->assertRedirect(route('transaksi.index'));
        $response->assertSessionHas('success', 'Data transaksi berhasil ditambahkan.');

        $this->assertDatabaseHas('inventaries', [
            'id' => $inventaris->id,
            'jumlah' => 5,
        ]);
    }

    public function test_store_penjualan_fails_when_stock_insufficient()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $mitra = Mitra::factory()->create();
        $inventaris = Inventaris::factory()->create(['jumlah' => 3]);

        $data = [
            'mitra_id' => $mitra->id,
            'user_id' => $user->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 5,
            'total_harga' => 50000,
            'tgl_transaksi' => now()->toDateString(),
            'status' => 'Penjualan',
        ];

        $response = $this->post(route('transaksi.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Stok tidak mencukupi untuk transaksi ini.');

        $this->assertDatabaseHas('inventaries', [
            'id' => $inventaris->id,
            'jumlah' => 3,
        ]);
    }

    public function test_store_pembelian_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $mitra = Mitra::factory()->create();
        $inventaris = Inventaris::factory()->create(['jumlah' => 10]);

        $data = [
            'mitra_id' => $mitra->id,
            'user_id' => $user->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 5,
            'total_harga' => 50000,
            'tgl_transaksi' => now()->toDateString(),
            'status' => 'Pembelian',
        ];

        $response = $this->post(route('transaksi.store'), $data);

        $response->assertRedirect(route('transaksi.index'));
        $response->assertSessionHas('success', 'Data transaksi berhasil ditambahkan.');

        $this->assertDatabaseHas('inventaries', [
            'id' => $inventaris->id,
            'jumlah' => 15,
        ]);
    }

    public function test_store_invalid_status_fails()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $mitra = Mitra::factory()->create();
        $inventaris = Inventaris::factory()->create(['jumlah' => 10]);

        $data = [
            'mitra_id' => $mitra->id,
            'user_id' => $user->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 5,
            'total_harga' => 50000,
            'tgl_transaksi' => now()->toDateString(),
            'status' => 'InvalidStatus',
        ];

        $response = $this->post(route('transaksi.store'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Status transaksi tidak valid.');

        $this->assertDatabaseHas('inventaries', [
            'id' => $inventaris->id,
            'jumlah' => 10,
        ]);
    }

    // ================================
    // TEST SHOW
    // ================================

    public function test_show_displays_detail()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $transaksi = Transaksi::factory()->create();

        $response = $this->get(route('transaksi.show', $transaksi->id));

        $response->assertStatus(200);
        $response->assertViewIs('transaksi.show');
        $response->assertViewHasAll(['pageTitle', 'transaksi', 'mitra', 'user', 'inventari']);
    }

    // ================================
    // TEST EDIT
    // ================================

    public function test_edit_displays_form()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $transaksi = Transaksi::factory()->create();

        $response = $this->get(route('transaksi.edit', $transaksi->id));

        $response->assertStatus(200);
        $response->assertViewIs('transaksi.edit');
        $response->assertViewHasAll(['pageTitle', 'transaksi', 'mitras', 'inventaris', 'user']);
    }

    // ================================
    // TEST UPDATE
    // ================================

    public function test_update_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $transaksi = Transaksi::factory()->create();
        $mitra = Mitra::factory()->create();
        $inventaris = Inventaris::factory()->create();

        $data = [
            'mitra_id' => $mitra->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 10,
            'total_harga' => 100000,
            'tgl_transaksi' => now()->toDateString(),
            'status' => 'Penjualan',
        ];

        $response = $this->put(route('transaksi.update', $transaksi->id), $data);

        $response->assertRedirect(route('transaksi.index'));
        $response->assertSessionHas('success', 'Data transaksi berhasil diperbarui.');

        $this->assertDatabaseHas('transaksis', [
            'id' => $transaksi->id,
            'mitra_id' => $mitra->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 10,
            'total_harga' => 100000,
            'status' => 'Penjualan',
        ]);
    }

    // ================================
    // TEST DELETE
    // ================================

    public function test_destroy_success()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $transaksi = Transaksi::factory()->create();

        $response = $this->delete(route('transaksi.destroy', $transaksi->id));

        $response->assertRedirect(route('transaksi.index'));
        $response->assertSessionHas('success', 'Data transaksi berhasil dihapus.');

        $this->assertDatabaseMissing('transaksis', [
            'id' => $transaksi->id,
        ]);
    }
}
