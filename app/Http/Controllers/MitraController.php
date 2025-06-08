<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mitra;

class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Data Mitra';
        $mitras = Mitra::all();

        // For now, just returning a view with the page title
        return view('mitra.index', ['pageTitle' => $pageTitle, 'mitras' => $mitras]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Tambah Mitra';
        // Return a view to create a new mitra
        return view('mitra.create', ['pageTitle' => $pageTitle]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255,email',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
        ]);

        if (Mitra::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'Email sudah digunakan, silakan gunakan email lain.');
        }
        if (Mitra::where('no_hp', $request->no_hp)->exists()) {
            return redirect()->back()->with('error', 'Nomor HP sudah digunakan, silakan gunakan nomor lain.');
        }

        $mitra = new Mitra();
        $mitra->nama = $request->input('nama');
        $mitra->email = $request->input('email');
        $mitra->no_hp = $request->input('no_hp');
        $mitra->alamat = $request->input('alamat');
        $mitra->save();

        return redirect()->route('mitras.index')->with('success', 'Data berhasil di tambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mitra = Mitra::findOrFail($id);
        $pageTitle = 'Edit Mitra';
        // Return a view to edit the mitra
        return view('mitra.edit', ['mitra' => $mitra, 'pageTitle' => $pageTitle]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255,email,' . $id,
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
        ]);

        if (Mitra::where('email', $request->email)->where('id', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'Email sudah digunakan, silakan gunakan email lain.');
        }
        if (Mitra::where('no_hp', $request->no_hp)->where('id', '!=', $id)->exists()) {
            return redirect()->back()->with('error', 'Nomor HP sudah digunakan, silakan gunakan nomor lain.');
        }

        $mitra = Mitra::findOrFail($id);
        $mitra->nama = $request->input('nama');
        $mitra->email = $request->input('email');
        $mitra->no_hp = $request->input('no_hp');
        $mitra->alamat = $request->input('alamat');
        $mitra->save();

        return redirect()->route('mitras.index')->with('success', 'Data berhasil di update.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();

        return redirect()->route('mitras.index')->with('success', 'Data berhasil di hapus.');
    }
}
