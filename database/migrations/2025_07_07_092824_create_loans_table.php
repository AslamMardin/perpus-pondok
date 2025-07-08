<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('loans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
    $table->foreignId('book_id')->constrained('books')->onDelete('restrict');
    $table->integer('jumlah_buku')->default(1);
    $table->date('tanggal_pinjam');
    $table->date('tanggal_tenggat')->nullable();
    $table->date('tanggal_kembali')->nullable();
    $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam'); // TANPA after()
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
