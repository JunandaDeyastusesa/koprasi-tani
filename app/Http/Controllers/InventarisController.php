<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaris;

class InventarisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Data Inventaris';
        // Assuming you have a model named Inventaris
        $inventaries = Inventaris::all();
        return view('inventaris.index', ['pageTitle' => $pageTitle, 'inventaries' => $inventaries]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Tambah Inventaris';
        $inventaries = Inventaris::all();
        return view('inventaris.create', ['inventaries' => $inventaries, 'pageTitle' => $pageTitle]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'harga_jual' => 'required|integer',
            'harga_beli' => 'required|integer',
            'jumlah' => 'required|integer',
            'deskripsi' => 'required|string|max:255',
        ]);
        if ($request->input('harga_jual') < 1 || $request->input('harga_beli') < 1) {
            return redirect()->back()->with('error', 'Harga jual dan harga beli harus lebih dari 0.');
        }

        $inventaris = new Inventaris();
        $inventaris->nama = $request->input('nama');
        $inventaris->kategori = $request->input('kategori');
        $inventaris->harga_jual = $request->input('harga_jual');
        $inventaris->harga_beli = $request->input('harga_beli');
        $inventaris->jumlah = $request->input('jumlah');
        $inventaris->deskripsi = $request->input('deskripsi');
        $inventaris->save();

        return redirect()->route('inventaris.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inventaris = Inventaris::findOrFail($id);
        $pageTitle = 'Detail Inventaris';
        return view('inventaris.show', ['inventaris' => $inventaris, 'pageTitle' => $pageTitle]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventaris = Inventaris::findOrFail($id);
        $pageTitle = 'Edit Inventaris';
        return view('inventaris.edit', ['inventaris' => $inventaris, 'pageTitle' => $pageTitle]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'harga_jual' => 'required|integer',
            'harga_beli' => 'required|integer',
            'jumlah' => 'required|integer',
            'deskripsi' => 'required|string|max:255',
        ]);

        if ($request->input('harga_jual') < 1 || $request->input('harga_beli') < 1) {
            return redirect()->back()->with('error', 'Harga jual dan harga beli harus lebih dari 0.');
        }

        $inventaris = Inventaris::findOrFail($id);
        $inventaris->nama = $request->input('nama');
        $inventaris->kategori = $request->input('kategori');
        $inventaris->harga_jual = $request->input('harga_jual');
        $inventaris->harga_beli = $request->input('harga_beli');
        $inventaris->jumlah = $request->input('jumlah');
        $inventaris->deskripsi = $request->input('deskripsi');
        $inventaris->save();

        return redirect()->route('inventaris.index')->with('success', 'Data berhasil diupdate.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventaris = Inventaris::findOrFail($id);
        $inventaris->delete();

        return redirect()->route('inventaris.index')->with('success', 'Data berhasil dihapus.');
    }
}
