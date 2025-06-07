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
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = Auth::user();

        // Ambil nama role pertama user (misalnya hanya 1 role per user)
        $role = $user->roles->first()->nama;

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

            // Urutkan berdasarkan tanggal dan jam (full datetime)
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

        // Jika role adalah Member
        if ($role === 'Member') {
            $pageTitle = 'Produk yang tersedia';
            $inventaries = Inventaris::all();

            // Kamu bisa sesuaikan isi dashboard.member di sini
            return view('dashboard.member', compact('pageTitle', 'inventaries'));
        }

        // Fallback jika role tidak dikenali
        abort(403, 'Akses ditolak.');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
