<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function tanggal()
    {
        return view('laporan.tanggal');
    }

    public function filter(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $data = Loan::with(['user', 'book'])
            ->whereBetween('tanggal_pinjam', [$request->tanggal_mulai, $request->tanggal_selesai])
            ->get();

        return view('laporan.index', compact('data'))
            ->with('tanggal_mulai', $request->tanggal_mulai)
            ->with('tanggal_selesai', $request->tanggal_selesai);
    }

    public function pengembalian() {
    // ambil data pengembalian
    $loans = Loan::where('status', 'dikembalikan')->with(['user', 'book'])->latest()->get();
    return view('laporan.pengembalian', compact('loans'));
}


public function peminjaman()
{
    $loans = Loan::with(['user', 'book'])->latest()->get();
    return view('laporan.peminjaman', compact('loans'));
}

}
