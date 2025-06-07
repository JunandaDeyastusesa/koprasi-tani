<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\Transaksi;
use App\Models\Inventaris;
use App\Models\Mitra;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat role Admin dan Member
        Role::factory()->create(['nama' => 'Admin']);
        Role::factory()->create(['nama' => 'Member']);
    }

    public function test_admin_can_access_dashboard_with_correct_data()
    {
        $roleAdmin = Role::where('nama', 'Admin')->first();
        $roleMember = Role::where('nama', 'Member')->first();

        // Buat user admin dan attach role admin
        $admin = User::factory()->create();
        $admin->roles()->attach($roleAdmin->id);

        // Buat data dummy transaksi, inventaris, mitra, dan user member
        Transaksi::factory()->count(5)->create(['status' => 'Penjualan', 'total_harga' => 10000]);
        Transaksi::factory()->count(3)->create(['status' => 'Pembelian', 'total_harga' => 5000]);
        Inventaris::factory()->count(2)->create();
        Mitra::factory()->count(1)->create();

        $members = User::factory()->count(3)->create();
        foreach ($members as $member) {
            $member->roles()->attach($roleMember->id);
        }

        $this->actingAs($admin);

        $response = $this->get(route('dashboard.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin');
        $response->assertViewHas('pageTitle', 'Dashboard Admin');
        $response->assertViewHas('data', function ($data) {
            return isset($data['total_pemasukan'])
                && isset($data['jumlah_member'])
                && isset($data['keuntungan'])
                && isset($data['total_pembelian'])
                && isset($data['penjualan'])
                && isset($data['pengeluaran']);
        });
    }

    public function test_member_can_access_dashboard_with_inventaris()
    {
        $roleMember = Role::where('nama', 'Member')->first();

        $member = User::factory()->create();
        $member->roles()->attach($roleMember->id);

        Inventaris::factory()->count(4)->create();

        $this->actingAs($member);

        $response = $this->get(route('dashboard.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.member');
        $response->assertViewHas('pageTitle', 'Dashboard Member');
        $response->assertViewHas('inventaries', function ($inventaries) {
            return $inventaries->count() === 4;
        });
    }

    public function test_access_denied_if_role_is_missing()
    {
        $user = User::factory()->create();
        // User tanpa role

        $this->actingAs($user);

        $response = $this->get(route('dashboard.index'));

        $response->assertStatus(403);
        $response->assertSee('Role tidak ditemukan.');
    }

    public function test_access_denied_if_role_is_not_admin_or_member()
    {
        $roleOther = Role::factory()->create(['nama' => 'Guest']);
        $user = User::factory()->create();
        $user->roles()->attach($roleOther->id);

        $this->actingAs($user);

        $response = $this->get(route('dashboard.index'));

        $response->assertStatus(403);
        $response->assertSee('Akses ditolak.');
    }
}
