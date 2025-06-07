<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Mitra;
use App\Models\Inventaris;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Hash;

class TransaksiControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Membuat role Member
        $role = Role::create(['nama' => 'Member']);

        // Membuat user Member
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'testuser',
            'password' => Hash::make('password')
        ]);
        $this->user->roles()->attach($role);

        $this->actingAs($this->user);
    }

    public function test_index_returns_success()
    {
        $response = $this->get(route('transaksi.index'));
        $response->assertStatus(200);
    }

    public function test_member_can_view_own_transactions()
    {
        $response = $this->get(route('viewTransaksiMember'));
        $response->assertStatus(200);
    }

    public function test_store_transaksi_penjualan()
    {
        $mitra = Mitra::factory()->create();
        $inventaris = Inventaris::factory()->create(['jumlah' => 10]);

        $response = $this->post(route('transaksi.store'), [
            'mitra_id' => $mitra->id,
            'user_id' => $this->user->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 2,
            'total_harga' => 20000,
            'tgl_transaksi' => now()->toDateString(),
            'status' => 'Penjualan',
        ]);

        $response->assertRedirect(route('transaksi.index'));
        $this->assertDatabaseHas('transaksis', ['jumlah' => 2, 'status' => 'Penjualan']);
    }

    public function test_store_transaksi_pembelian()
    {
        $inventaris = Inventaris::factory()->create(['jumlah' => 5]);

        $response = $this->post(route('transaksi.store'), [
            'mitra_id' => null,
            'user_id' => $this->user->id,
            'inventari_id' => $inventaris->id,
            'jumlah' => 3,
            'total_harga' => 15000,
            'tgl_transaksi' => now()->toDateString(),
            'status' => 'Pembelian',
        ]);

        $response->assertRedirect(route('transaksi.index'));
        $this->assertDatabaseHas('transaksis', ['jumlah' => 3, 'status' => 'Pembelian']);
    }

    public function test_delete_transaksi()
    {
        $transaksi = Transaksi::factory()->create();

        $response = $this->delete(route('transaksi.destroy', $transaksi->id));
        $response->assertRedirect(route('transaksi.index'));
        $this->assertDatabaseMissing('transaksis', ['id' => $transaksi->id]);
    }
}
