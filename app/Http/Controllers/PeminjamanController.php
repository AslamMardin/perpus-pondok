<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\User;
use App\Models\Book;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
{
    $query = Loan::with(['user', 'book']);

    if ($request->filter == 'terlambat') {
        $query->where('status', 'dipinjam')
              ->whereDate('tanggal_tenggat', '<', now());
    } elseif ($request->filter == 'dipinjam') {
        $query->where('status', 'dipinjam');
    } elseif ($request->filter == 'dikembalikan') {
        $query->where('status', 'dikembalikan');
    }

    $loans = $query->latest()->get();

    return view('peminjaman.index', compact('loans'));
}

    public function create()
    {
        $users = User::all();
        $books = Book::all();
        return view('peminjaman.create', compact('users', 'books'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        Loan::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status' => 'dipinjam',
        ]);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dicatat.');
    }

    public function edit(Loan $peminjaman)
    {
        $users = User::all();
        $books = Book::all();
        return view('peminjaman.edit', compact('peminjaman', 'users', 'books'));
    }

    public function update(Request $request, Loan $peminjaman)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'status' => 'required|in:dipinjam,dikembalikan',
        ]);

        $peminjaman->update($request->all());
        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman diperbarui.');
    }

    public function destroy(Loan $peminjaman)
    {
        $peminjaman->delete();
        return back()->with('success', 'Peminjaman berhasil dihapus.');
    }

    public function toggleStatus(Loan $loan)
{
    $loan->status = $loan->status === 'dipinjam' ? 'dikembalikan' : 'dipinjam';

    // Update tanggal_kembali jika status jadi dikembalikan
    if ($loan->status === 'dikembalikan') {
        $loan->tanggal_kembali = now();
    } else {
        $loan->tanggal_kembali = null;
    }

    $loan->save();

    return response()->json(['success' => true, 'status' => $loan->status]);
}

public function riwayat(Request $request)
{
    $kelas = $request->kelas;
    $query = Loan::with(['user', 'book'])
                ->where('status', 'dikembalikan')
                ->when($kelas, fn($q) => $q->whereHas('user', fn($uq) => $uq->where('kelas', $kelas)))
                ->orderByDesc('tanggal_kembali');

    $loans = $query->get();

    $daftarKelas = User::whereNotNull('kelas')->distinct()->pluck('kelas');

    return view('peminjaman.riwayat', compact('loans', 'daftarKelas', 'kelas'));
}


}
