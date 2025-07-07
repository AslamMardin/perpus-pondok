<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PeminjamanController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // route lainnya yang hanya untuk admin
    Route::get('/admin', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('/buku', BookController::class)->parameters([
    'buku' => 'buku' // agar route binding cocok dengan variabel $buku
]);
Route::get('/api/buku/{id}', function ($id) {
    return \App\Models\Book::find($id);
});


Route::resource('/pengguna', PenggunaController::class)->parameters([
    'pengguna' => 'pengguna' // agar route binding cocok dengan variabel $buku
]);

Route::resource('/peminjaman', PeminjamanController::class)->parameters([
    'peminjaman' => 'peminjaman' // agar route binding cocok dengan variabel $buku
]);

Route::post('/peminjaman/{loan}/toggle-status', [PeminjamanController::class, 'toggleStatus'])->name('peminjaman.toggleStatus');
Route::get('/riwayat-pengembalian', [PeminjamanController::class, 'riwayat'])->name('riwayat.pengembalian');


Route::resource('/pengembalian', BookController::class)->parameters([
    'pengembalian' => 'pengembalian' // agar route binding cocok dengan variabel $buku
]);

Route::resource('/laporan', BookController::class)->parameters([
    'laporan' => 'laporan' // agar route binding cocok dengan variabel $buku
]);
 Route::get('/pengaturan', [AdminController::class, 'pengaturan'])->name('pengaturan');
  Route::post('/pengaturan', [AdminController::class, 'updatePengaturan'])->name('pengaturan.update');
});