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

    public function store(Request $request)
    {
        // Validasi input dulu
        $request->validate([
            'mitra_id' => 'nullable|exists:mitras,id',
            'user_id' => 'nullable|exists:users,id',
            'inventari_id' => 'required|exists:inventaris,id', // ini harus inventaris bukan inventaries
            'jumlah' => 'required|integer|min:1',
            'total_harga' => 'required|integer|min:1',
            'tgl_transaksi' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        try {
            $inventaris = Inventaris::findOrFail($request->inventari_id);

            if ($request->status === 'Penjualan') {
                if ($inventaris->jumlah < $request->jumlah) {
                    return redirect()->back()->with('error', 'Stok tidak mencukupi untuk transaksi ini.');
                }
                $inventaris->jumlah -= $request->jumlah;
                $inventaris->save();
            } elseif ($request->status === 'Pembelian') {
                $inventaris->jumlah += $request->jumlah;
                $inventaris->save();
            } else {
                return redirect()->back()->with('error', 'Status transaksi tidak valid.');
            }

            $transaksi = new Transaksi();
            $transaksi->mitra_id = $request->input('mitra_id');
            $transaksi->user_id = $request->input('user_id');
            $transaksi->inventari_id = $request->input('inventari_id');
            $transaksi->jumlah = $request->input('jumlah');
            $transaksi->total_harga = $request->input('total_harga');
            $transaksi->tgl_transaksi = $request->input('tgl_transaksi');
            $transaksi->status = $request->input('status');
            $transaksi->save();

            return redirect()->route('transaksi.index')->with('success', 'Data transaksi berhasil ditambahkan.');

        } catch (\Exception $e) {
            \Log::error('Error store transaksi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan transaksi.');
        }
    }

    public function show(string $id)
    {
        $pageTitle = 'Detail Transaksi';
        $transaksi = Transaksi::findOrFail($id);

        $mitra = Mitra::find($transaksi->mitra_id);
        $user = User::find($transaksi->user_id);
        $inventari = Inventaris::find($transaksi->inventari_id);

        return view('transaksi.show', compact('pageTitle', 'transaksi', 'mitra', 'user', 'inventari'));
    }

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

public function update(Request $request, string $id)
{
    $request->validate([
        'mitra_id' => 'required|exists:mitras,id',
        'inventari_id' => 'required|exists:inventaris,id',
        'jumlah' => 'required|integer|min:1',
        'total_harga' => 'required|integer|min:1',
        'tgl_transaksi' => 'required|date',
        'status' => 'required|string|max:255',
    ]);

    try {
        $transaksi = Transaksi::findOrFail($id);
        $inventarisLama = Inventaris::findOrFail($transaksi->inventari_id);
        $inventarisBaru = Inventaris::findOrFail($request->inventari_id);

        // Jika inventaris berubah
        if ($transaksi->inventari_id != $request->inventari_id) {
            // Rollback stok inventaris lama
            if ($transaksi->status === 'Penjualan') {
                $inventarisLama->jumlah += $transaksi->jumlah;
            } elseif ($transaksi->status === 'Pembelian') {
                $inventarisLama->jumlah -= $transaksi->jumlah;
            }
            $inventarisLama->save();

            // Update stok inventaris baru berdasarkan status baru
            if ($request->status === 'Penjualan') {
                if ($inventarisBaru->jumlah < $request->jumlah) {
                    return redirect()->back()->with('error', 'Stok tidak mencukupi untuk transaksi ini.');
                }
                $inventarisBaru->jumlah -= $request->jumlah;
            } elseif ($request->status === 'Pembelian') {
                $inventarisBaru->jumlah += $request->jumlah;
            } else {
                return redirect()->back()->with('error', 'Status transaksi tidak valid.');
            }
            $inventarisBaru->save();
        } else {
            // Jika inventaris sama, hitung selisih jumlah dan sesuaikan stok
            $selisihJumlah = $request->jumlah - $transaksi->jumlah;

            if ($request->status === 'Penjualan') {
                if ($inventarisBaru->jumlah < $selisihJumlah) {
                    return redirect()->back()->with('error', 'Stok tidak mencukupi untuk perubahan jumlah.');
                }
                $inventarisBaru->jumlah -= $selisihJumlah;
            } elseif ($request->status === 'Pembelian') {
                $inventarisBaru->jumlah += $selisihJumlah;
            } else {
                return redirect()->back()->with('error', 'Status transaksi tidak valid.');
            }
            $inventarisBaru->save();
        }

        // Update transaksi
        $transaksi->mitra_id = $request->input('mitra_id');
        $transaksi->inventari_id = $request->input('inventari_id');
        $transaksi->jumlah = $request->input('jumlah');
        $transaksi->total_harga = $request->input('total_harga');
        $transaksi->tgl_transaksi = $request->input('tgl_transaksi');
        $transaksi->status = $request->input('status');
        $transaksi->save();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diupdate.');
    } catch (\Exception $e) {
        \Log::error('Error update transaksi: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui transaksi.');
    }
}


    public function destroy(string $id)
    {
        try {
            $transaksi = Transaksi::findOrFail($id);

            // Rollback stok inventaris sebelum hapus transaksi
            $inventaris = Inventaris::findOrFail($transaksi->inventari_id);
            if ($transaksi->status === 'Penjualan') {
                $inventaris->jumlah += $transaksi->jumlah;
            } elseif ($transaksi->status === 'Pembelian') {
                $inventaris->jumlah -= $transaksi->jumlah;
            }
            $inventaris->save();

            $transaksi->delete();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
        } catch (\Exception $e) {
            \Log::error('Error delete transaksi: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus transaksi.');
        }
    }
}
