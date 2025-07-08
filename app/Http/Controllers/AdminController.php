<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
  public function index()
    {
        $totalBooks = Book::count();
        $totalUsers = User::count();
        $borrowedBooks = Loan::where('status', 'dipinjam')->count();


        // Ambil hanya aktivitas yang terjadi hari ini (pinjam atau kembali)
        $recentLoans = Loan::with(['user', 'book'])
            ->where(function ($query) {
                $query->whereDate('tanggal_pinjam', Carbon::today())
                      ->orWhereDate('tanggal_kembali', Carbon::today());
            })
            ->latest()
            ->get();

        return view('admin.index', compact(
            'totalBooks',
            'totalUsers',
            'borrowedBooks',
   
            'recentLoans'
        ));
    }

    public function pengaturan()
{
    $user = Auth::user();
    return view('admin.pengaturan.index', compact('user'));
}


public function updatePengaturan(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'nama' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $user->id,
        'password' => 'nullable|string|min:6',
        'kode_keamanan' => 'required|string',
    ], [
        'nama.required' => 'Nama wajib diisi.',
        'username.required' => 'Username wajib diisi.',
        'username.unique' => 'Username sudah digunakan.',
        'password.min' => 'Password minimal 6 karakter.',
        'kode_keamanan.required' => 'Kode keamanan harus diisi.',
    ]);

    // Cek kode keamanan
    if ($request->kode_keamanan !== 'lampoko') {
        return back()->withErrors(['kode_keamanan' => 'Kode keamanan salah. Perubahan tidak disimpan.'])->withInput();
    }

    // Update data
    $user->nama = $request->nama;
    $user->username = $request->username;

    // Ganti password jika diisi
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('pengaturan')->with('success', 'Data berhasil diperbarui.');
}




}
