<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanTanggalExport;

class LaporanController extends Controller
{
  


   public function pengembalian()
{
    $loans = Loan::with(['user', 'book'])
        ->where('status', 'dikembalikan')
        ->latest('tanggal_kembali')
        ->get();

    return view('laporan.pengembalian', compact('loans'));
}



public function exportPengembalianPdf()
{
    $loans = Loan::with(['user', 'book'])
        ->where('status', 'dikembalikan')
        ->latest('tanggal_kembali')
        ->get();

    $pdf = Pdf::loadView('laporan.pdf.pengembalian', compact('loans'));
    return $pdf->download('laporan_pengembalian.pdf');
}




public function peminjaman()
{
    $loans = Loan::with(['user', 'book'])->latest()->get();
    return view('laporan.peminjaman', compact('loans'));
}

public function exportPeminjamanPdf()
{
    $loans = Loan::with(['user', 'book'])->get();

    $pdf = Pdf::loadView('laporan.pdf.peminjaman', compact('loans'));
    return $pdf->download('laporan_peminjaman.pdf');
}

public function terlambat()
{
    $loans = \App\Models\Loan::with(['user', 'book'])
        ->where(function ($q) {
            $q->where(function ($sub) {
                // Masih dipinjam dan melewati tenggat
                $sub->where('status', 'dipinjam')
                    ->whereDate('tanggal_tenggat', '<', now());
            })->orWhere(function ($sub) {
                // Sudah dikembalikan tapi lewat tenggat
                $sub->where('status', 'dikembalikan')
                    ->whereColumn('tanggal_kembali', '>', 'tanggal_tenggat');
            });
        })
        ->get();

    return view('laporan.terlambat', compact('loans'));
}


public function exportTerlambatPdf()
{
    $loans = Loan::with(['user', 'book'])
        ->where(function ($q) {
            $q->where(function ($sub) {
                $sub->where('status', 'dipinjam')
                    ->whereDate('tanggal_tenggat', '<', now());
            })->orWhere(function ($sub) {
                $sub->where('status', 'dikembalikan')
                    ->whereColumn('tanggal_kembali', '>', 'tanggal_tenggat');
            });
        })
        ->get();

    $pdf = PDF::loadView('laporan.pdf.terlambat', compact('loans'))
        ->setPaper('A4', 'landscape');

    return $pdf->download('laporan-terlambat.pdf');
}


public function tanggal()
{
    return view('laporan.tanggal', ['loans' => []]);
}
public function filterTanggal(Request $request)
{
    $request->validate([
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
    ]);

    $tanggal_mulai = $request->tanggal_mulai;
    $tanggal_selesai = $request->tanggal_selesai;

    $loans = Loan::with(['user', 'book'])
        ->whereBetween('tanggal_pinjam', [$tanggal_mulai, $tanggal_selesai])
        ->orderBy('tanggal_pinjam', 'asc')
        ->get();

    return view('laporan.tanggal', compact('loans', 'tanggal_mulai', 'tanggal_selesai'));
}


public function exportTanggalPdf($dari, $sampai)
{
    $loans = Loan::with(['user', 'book'])
        ->whereBetween('tanggal_pinjam', [$dari, $sampai])
        ->orderBy('tanggal_pinjam', 'asc')
        ->get();

    $pdf = Pdf::loadView('laporan.pdf.tanggal', compact('loans', 'dari', 'sampai'))
        ->setPaper('A4', 'landscape');

    return $pdf->download('laporan_peminjaman_tanggal.pdf');
}



public function exportTanggalExcel($dari, $sampai)
{
    return Excel::download(new LaporanTanggalExport($dari, $sampai), 'laporan_peminjaman_tanggal.xlsx');
}


public function santri()
{
    $santriList = User::where('peran', 'santri')->orderBy('nama')->get();
    return view('laporan.santri', compact('santriList'))->with('loans', []);
}

public function filterSantri(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    $loans = Loan::with(['user', 'book'])
        ->where('user_id', $request->user_id)
        ->orderBy('tanggal_pinjam', 'desc')
        ->get();

    $santriList = User::where('peran', 'santri')->orderBy('nama')->get();

    return view('laporan.santri', compact('loans', 'santriList'));
}

public function exportSantriPdf($id)
{
    $santri = User::findOrFail($id);
    $loans = Loan::with('book')
                ->where('user_id', $id)
                ->orderBy('tanggal_pinjam', 'asc')
                ->get();

    $pdf = PDF::loadView('laporan.santri_pdf', compact('santri', 'loans'))
              ->setPaper('A4', 'portrait');

    return $pdf->download('Laporan_Santri_'.$santri->nama.'.pdf');
}

public function grafikView(Request $request)
    {
         $tahunSekarang = date('Y');
    $tahun = $request->tahun ?? $tahunSekarang;

    // Range tahun: tahun ini -2 sampai +2
    $daftarTahun = collect(range($tahunSekarang - 2, $tahunSekarang + 2));

    $data = \App\Models\Loan::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
                ->whereYear('tanggal_pinjam', $tahun)
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->pluck('total', 'bulan')
                ->toArray();

    $bulanIndo = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    $bulanIslami = [
        'Muharram', 'Safar', 'Rabiul Awal', 'Rabiul Akhir',
        'Jumadil Awal', 'Jumadil Akhir', 'Rajab', 'Syaban',
        'Ramadhan', 'Syawal', 'Zulqaidah', 'Zulhijjah'
    ];

    $labels = [];
    $totals = [];
    for ($i = 1; $i <= 12; $i++) {
        $labels[] = [$bulanIndo[$i], '(' . $bulanIslami[$i - 1] . ')'];
        $totals[] = $data[$i] ?? 0;
    }

    return view('laporan.peminjaman_bulanan', compact('labels', 'totals', 'tahun', 'daftarTahun'));
    }



}
