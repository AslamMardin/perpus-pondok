<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;
use App\Exports\PengembalianExport;
use App\Exports\TerlambatExport;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Halaman Utama & Autentikasi
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Group Route Dengan Middleware Auth
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard & Pengaturan
    |--------------------------------------------------------------------------
    */
    Route::get('/admin', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/pengaturan', [AdminController::class, 'pengaturan'])->name('pengaturan');
    Route::post('/pengaturan', [AdminController::class, 'updatePengaturan'])->name('pengaturan.update');

    /*
    |--------------------------------------------------------------------------
    | Manajemen Buku, Pengguna, dan Peminjaman
    |--------------------------------------------------------------------------
    */
    Route::resource('/buku', BookController::class)->parameters(['buku' => 'buku']);
    Route::resource('/pengguna', PenggunaController::class)->parameters(['pengguna' => 'pengguna']);
    Route::resource('/peminjaman', PeminjamanController::class)->parameters(['peminjaman' => 'peminjaman']);

    // API data buku (misalnya untuk autocomplete form)
    Route::get('/api/buku/{id}', fn($id) => \App\Models\Book::find($id));

    // Ubah status peminjaman (dipinjam <-> dikembalikan)
    Route::post('/peminjaman/{loan}/toggle-status', [PeminjamanController::class, 'toggleStatus'])->name('peminjaman.toggleStatus');

    // Riwayat pengembalian
    Route::get('/riwayat-pengembalian', [PeminjamanController::class, 'riwayat'])->name('riwayat.pengembalian');

    /*
    |--------------------------------------------------------------------------
    | Laporan: Peminjaman, Pengembalian, Terlambat, Tanggal, Santri
    |--------------------------------------------------------------------------
    */
    Route::prefix('laporan')->name('laporan.')->group(function () {
        // Peminjaman
        Route::get('peminjaman', [LaporanController::class, 'peminjaman'])->name('peminjaman');
        Route::get('peminjaman/pdf', [LaporanController::class, 'exportPeminjamanPdf'])->name('peminjaman.pdf');
        Route::get('peminjaman/excel', fn() => Excel::download(new PeminjamanExport, 'laporan_peminjaman.xlsx'))->name('peminjaman.excel');

        // Pengembalian
        Route::get('pengembalian', [LaporanController::class, 'pengembalian'])->name('pengembalian');
        Route::get('pengembalian/pdf', [LaporanController::class, 'exportPengembalianPdf'])->name('pengembalian.pdf');
        Route::get('pengembalian/excel', fn() => Excel::download(new PengembalianExport, 'laporan_pengembalian.xlsx'))->name('pengembalian.excel');

        // Terlambat
        Route::get('terlambat', [LaporanController::class, 'terlambat'])->name('terlambat');
        Route::get('terlambat/pdf', [LaporanController::class, 'exportTerlambatPdf'])->name('terlambat.pdf');
        Route::get('terlambat/excel', fn() => Excel::download(new TerlambatExport, 'laporan_terlambat.xlsx'))->name('terlambat.excel');

        // Berdasarkan Tanggal
        Route::get('tanggal', [LaporanController::class, 'tanggal'])->name('tanggal');
        Route::post('tanggal', [LaporanController::class, 'filterTanggal'])->name('tanggal.filter');
        Route::get('tanggal/export/pdf/{dari}/{sampai}', [LaporanController::class, 'exportTanggalPdf'])->name('tanggal.pdf');
        Route::get('tanggal/export/excel/{dari}/{sampai}', [LaporanController::class, 'exportTanggalExcel'])->name('tanggal.excel');

        // Per Santri
        Route::get('santri', [LaporanController::class, 'santri'])->name('santri');
        Route::post('santri', [LaporanController::class, 'filterSantri'])->name('santri.filter');
    });

});
