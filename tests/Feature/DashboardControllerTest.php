<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Transaksi;
use App\Models\Mitra;
use App\Models\Inventaris;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_access_dashboard()
    {
        $role = Role::create(['nama' => 'Admin']);
        $admin = User::factory()->create();
        $admin->roles()->attach($role);

        $this->actingAs($admin);

        // Setup data dummy
        Transaksi::factory()->count(3)->create(['status' => 'Penjualan']);
        Transaksi::factory()->count(2)->create(['status' => 'Pembelian']);
        Mitra::factory()->count(2)->create();
        Inventaris::factory()->count(5)->create();

        $response = $this->get(route('dashboard.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.admin');
        $response->assertViewHas('data');
    }

    /** @test */
    public function member_can_access_dashboard()
    {
        $role = Role::create(['nama' => 'Member']);
        $member = User::factory()->create();
        $member->roles()->attach($role);

        $this->actingAs($member);

        Inventaris::factory()->count(5)->create();

        $response = $this->get(route('dashboard.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.member');
        $response->assertViewHas('inventaries');
    }

    /** @test */
    public function unauthorized_user_gets_403()
    {
        $role = Role::create(['nama' => 'Guest']);
        $user = User::factory()->create();
        $user->roles()->attach($role);

        $this->actingAs($user);

        $response = $this->get(route('dashboard.index'));
        $response->assertStatus(403);
    }

}
