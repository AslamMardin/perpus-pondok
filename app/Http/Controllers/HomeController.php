<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use Carbon\Carbon;
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

        return view('home', compact('loans'));
    }
}
