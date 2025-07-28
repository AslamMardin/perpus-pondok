<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $users = User::when($search, function ($query, $search) {
            $query->where('nama', 'like', "%$search%")
                  ->orWhere('username', 'like', "%$search%");
        })->get();

        return view('pengguna.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
    'nama' => 'required|string|max:255',
    'username' => 'required|string|unique:users',
    'kelas' => 'nullable|string',
], [
    'nama.required' => 'Nama wajib diisi.',
    'username.required' => 'Username wajib diisi.',
    'username.unique' => 'santri sudah ada.',
]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => Hash::make('santri123'),
            'kelas' => $request->kelas,
            'peran' => 'santri'
        ]);

        return back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $pengguna)
    {
        return view('pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, User $pengguna)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,' . $pengguna->id,
            'password' => 'nullable|string|min:6|confirmed',
            'kelas' => 'nullable|string',
            'peran' => 'required|in:admin,santri'
        ]);

        $pengguna->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'kelas' => $request->kelas,
            'peran' => $request->peran,
            'password' => $request->password ? Hash::make($request->password) : $pengguna->password
        ]);

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $pengguna)
    {

        if ($pengguna->loans()->count() > 0) {
        return back()->withErrors([
            'msg' => "Pengguna dengan nama {$pengguna->nama} tidak dapat dihapus karena masih memiliki data peminjaman."
        ]);
    }
        $pengguna->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function halamanKartu($id)
{
    $user = User::findOrFail($id);
    return view('pengguna.kartu-print', compact('user'));
}

public function cetakSemua()
{
    $users = User::all();
    return view('pengguna.cetak-semua', compact('users'));
}
}
