<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
  public function index(Request $request)
{
    $query = Loan::with(['user', 'book']);

    // Filter status
    if ($request->filter == 'terlambat') {
        $query->where('status', 'dipinjam')
              ->whereDate('tanggal_tenggat', '<', now());
    } elseif ($request->filter == 'dipinjam') {
        $query->where('status', 'dipinjam');
    } elseif ($request->filter == 'dikembalikan') {
        $query->where('status', 'dikembalikan');
    } elseif ($request->filter == 'hari_ini') {
        $query->whereDate('tanggal_pinjam', today());
    }

    // Pencarian: nama santri atau judul buku
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->whereHas('user', function ($qUser) use ($search) {
                $qUser->where('nama', 'like', '%' . $search . '%');
            })->orWhereHas('book', function ($qBook) use ($search) {
                $qBook->where('judul', 'like', '%' . $search . '%');
            });
        });
    }

    $loans = $query->latest()->paginate(10)->withQueryString(); // withQueryString agar filter & search tetap terjaga saat pagination

    return view('peminjaman.index', compact('loans'));
}



 public function create()
{
    // Ambil semua santri
    $users = User::where('peran', 'santri')->orderBy('kelas')->orderBy('nama')->get();

    // Kelompokkan berdasarkan kelas (kelas bisa 7 A SMP, dst)
    $kelasUrut = $users->pluck('kelas')->unique()->values()->all();

    // Kelompokkan user per kelas
    $santriPerKelas = $users->groupBy('kelas');

    return view('peminjaman.create', compact('users', 'kelasUrut', 'santriPerKelas'));
}



   public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'book_id' => 'required|exists:books,id',
        'jumlah_buku' => 'required|integer|min:1',
        'tanggal_pinjam' => 'required|date',
        'tanggal_kembali' => 'nullable|date',
        'status' => 'required|in:dipinjam,dikembalikan',
    ]);

   

    $tanggalPinjam = \Carbon\Carbon::parse($request->tanggal_pinjam);
    $tanggalTenggat = \Carbon\Carbon::parse($request->tanggal_pinjam); // tenggat = 7 hari


Loan::create([
    'user_id' => $request->user_id,
    'book_id' => $request->book_id,
    'tanggal_pinjam' => $tanggalPinjam,
    'jumlah_buku' => $request->jumlah_buku,
        'tanggal_tenggat' => $tanggalTenggat,
        'tanggal_kembali' => null,
        'status' => $request->status,
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
    // Validasi hanya untuk status & tanggal
    $request->validate([
        'status' => 'required|in:dipinjam,dikembalikan',
    ]);

    // Update status
    $peminjaman->status = $request->status;

    // Jika dikembalikan, set tanggal_kembali otomatis
    if ($request->status === 'dikembalikan') {
        $peminjaman->tanggal_kembali = now();
    }

    // Jika kembali ke dipinjam, kosongkan tanggal_kembali
    if ($request->status === 'dipinjam') {
        $peminjaman->tanggal_kembali = null;
    }

    $peminjaman->save();

    return redirect()
        ->route('peminjaman.index')
        ->with('success', 'Status peminjaman berhasil diperbarui.');
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
    $query = Loan::with(['user', 'book'])
        ->where('status', 'dikembalikan'); // Ambil hanya yang sudah dikembalikan

  
    // Filter keterlambatan
    if ($request->tanggal == 'terlambat') {
        $query->whereColumn('tanggal_kembali', '>', 'tanggal_tenggat');
    }

    // Filter kelas
    if ($request->kelas) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('kelas', $request->kelas);
        });
    }

    $loans = $query->orderByDesc('tanggal_kembali')->paginate(10);

    // Ambil daftar kelas unik dari user
    $daftarKelas = User::select('kelas')->distinct()->pluck('kelas')->filter()->values();

    return view('peminjaman.riwayat', compact('loans', 'daftarKelas'));
}








}
