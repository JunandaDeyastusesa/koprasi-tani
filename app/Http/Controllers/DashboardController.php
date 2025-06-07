<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inventaris;
use App\Models\Transaksi;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    $role = $user->roles->first()?->nama;

    if (!$role) {
        abort(403, 'Role tidak ditemukan.');
    }

    if ($role === 'Admin') {
        $pageTitle = 'Dashboard Admin';

        $transaksi = Transaksi::all();
        $inventaris = Inventaris::all();
        $mitras = Mitra::all();

        $users = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('nama', 'Member');
        })->get();

        $total_pemasukan = $transaksi->where('status', 'Penjualan')->sum('total_harga');
        $total_pembelian = $transaksi->where('status', 'Pembelian')->sum('total_harga');

        $penjualan = $transaksi->where('status', 'Penjualan')->sortByDesc('tgl_transaksi')->take(10);
        $pengeluaran = $transaksi->where('status', 'Pembelian')->sortByDesc('tgl_transaksi')->take(10);

        $jumlah_member = $users->count();
        $keuntungan = $total_pemasukan - $total_pembelian;

        $data = [
            'total_pemasukan' => $total_pemasukan,
            'jumlah_member' => $jumlah_member,
            'keuntungan' => $keuntungan,
            'total_pembelian' => $total_pembelian,
            'penjualan' => $penjualan,
            'pengeluaran' => $pengeluaran,
        ];

        return view('dashboard.admin', compact('pageTitle', 'data'));
    }

    if ($role === 'Member') {
        $pageTitle = 'Dashboard Member';
        $inventaries = Inventaris::all();

        return view('dashboard.member', compact('pageTitle', 'inventaries'));
    }

    abort(403, 'Akses ditolak.');
}

    public function store(Request $request)
    {
        //
    }
    

    public function show(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
