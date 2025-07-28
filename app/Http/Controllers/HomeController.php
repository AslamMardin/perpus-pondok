<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
     public function index()
    {
        $today = Carbon::today()->toDateString();

        $loans = Loan::with(['user', 'book'])
            ->whereDate('tanggal_pinjam', $today)
            ->orWhereDate('tanggal_kembali', $today)
            ->latest()
            ->get();

              // Ambil semua buku (untuk pencarian di modal)
    $books = Book::with('rak')->orderBy('judul')->get();

    return view('home', compact('loans', 'books'));
    }
}
