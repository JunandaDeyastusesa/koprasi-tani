<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{

    public function index()
    {
        $pageTitle = 'Data Member';
        $users = User::with('roles')->whereHas('roles', function ($query) {
            $query->where('nama', 'Member');
        })->get();
        return view('member.index', ['pageTitle' => $pageTitle, 'users' => $users]);
    }

    public function create()
    {
        $pageTitle = 'Add member';
        $users = User::all();
        return view('member.create', ['users' => $users, 'pageTitle' => $pageTitle]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'username' => 'required|string',
            'password' => 'required|min:6|confirmed',
            'role'     => 'required|in:Member,Admin',
        ]);

        // Cek jika email sudah ada
        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'Email sudah digunakan, silakan gunakan email lain.');
        }

        // Cek jika username sudah ada
        if (User::where('username', $request->username)->exists()) {
            return redirect()->back()->with('error', 'Username sudah digunakan, silakan pilih username lain.');
        }

        // Simpan user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        // Tambahkan role
        $role = Role::where('nama', $request->role)->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }

        return redirect()->route('members.index')->with('success', 'Pendaftaran berhasil sebagai ' . $request->role);
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('member.edit', compact('user'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'username' => 'required|string|unique:users,username,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('members.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->roles()->where('nama', 'Member')->exists()) {
            $user->roles()->detach();
        }
        $user->delete();

        return redirect()->route('members.index')->with('success', 'Data berhasil dihapus');
    }
}
