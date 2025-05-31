<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Inventaris;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Data Transaksi';
        $transaksis = Transaksi::all();
        $mitras = Mitra::all();
        $inventaris = Inventaris::all();

        return view('transaksi.index', ['pageTitle' => $pageTitle, 'transaksis' => $transaksis, 'mitras' => $mitras, 'inventaris' => $inventaris]);
    }


    public function viewTransaksiMember()
    {
        $pageTitle = 'Data Transaksi';

        // Ambil hanya transaksi milik user yang sedang login
        $transaksis = Transaksi::where('user_id', Auth::id())->get();

        $mitras = Mitra::all();
        $inventaris = Inventaris::all();

        return view('transaksi.transaksiMember', [
            'pageTitle' => $pageTitle,
            'transaksis' => $transaksis,
            'mitras' => $mitras,
            'inventaris' => $inventaris
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Tambah Transaksi';
        $mitras = Mitra::all();
        $inventaris = Inventaris::all();
        $user = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('nama', 'Member');
        })->get();

        return view('transaksi.create', ['pageTitle' => $pageTitle, 'mitras' => $mitras, 'inventaris' => $inventaris, 'user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'mitra_id' => 'nullable|exists:mitras,id',
            'user_id' => 'nullable|exists:users,id',
            'inventari_id' => 'required|exists:inventaries,id',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|integer|min:1',
            'tgl_transaksi' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $inventaris = Inventaris::find($request->inventari_id);

        if ($request->status === 'Penjualan') {
            if ($inventaris->jumlah < $request->jumlah) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk transaksi ini.');
            }

            $inventaris->jumlah -= $request->jumlah;
            $inventaris->save();
        } else if ($request->status === 'Pembelian') {
            $inventaris->jumlah += $request->jumlah;
            $inventaris->save();
        } else {
            return redirect()->back()->with('error', 'Status transaksi tidak valid.');
        }

        $transaksis = new Transaksi();
        $transaksis->mitra_id = $request->input('mitra_id');
        $transaksis->user_id = $request->input('user_id');
        $transaksis->inventari_id = $request->input('inventari_id');
        $transaksis->jumlah = $request->input('jumlah');
        $transaksis->total_harga = $request->input('total_harga');
        $transaksis->tgl_transaksi = $request->input('tgl_transaksi');
        $transaksis->status = $request->input('status');
        $transaksis->save();

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pageTitle = 'Detail Transaksi';
        $transaksi = Transaksi::findOrFail($id);

        $mitra = Mitra::find($transaksi->mitra_id); // ← aman walau null
        $user = User::find($transaksi->user_id);
        $inventari = Inventaris::find($transaksi->inventari_id);

        return view('transaksi.show', compact('pageTitle', 'transaksi', 'mitra', 'user', 'inventari'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Edit Transaksi';
        $transaksi = Transaksi::findOrFail($id);
        $mitras = Mitra::all();
        $inventaris = Inventaris::all();
        $user = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('nama', 'Member');
        })->get();

        return view('transaksi.edit', ['pageTitle' => $pageTitle, 'transaksi' => $transaksi, 'mitras' => $mitras, 'inventaris' => $inventaris, 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'mitra_id' => 'required|exists:mitras,id',
            'inventari_id' => 'required|exists:inventaries,id',
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|integer|min:1',
            'tgl_transaksi' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->mitra_id = $request->input('mitra_id');
        $transaksi->inventari_id = $request->input('inventari_id');
        $transaksi->jumlah = $request->input('jumlah');
        $transaksi->total_harga = $request->input('total_harga');
        $transaksi->tgl_transaksi = $request->input('tgl_transaksi');
        $transaksi->status = $request->input('status');
        $transaksi->save();

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil dihapus.');
    }
}
