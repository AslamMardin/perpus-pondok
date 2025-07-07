@csrf

<div class="mb-3">
    <label>Santri</label>
    <select name="user_id" class="form-select" required>
        <option value="">-- Pilih Santri --</option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}"
                {{ old('user_id', $peminjaman->user_id ?? '') == $user->id ? 'selected' : '' }}>
                {{ $user->nama }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Buku</label>
    <select name="book_id" class="form-select" required>
        <option value="">-- Pilih Buku --</option>
        @foreach ($books as $book)
            <option value="{{ $book->id }}"
                {{ old('book_id', $peminjaman->book_id ?? '') == $book->id ? 'selected' : '' }}>
                {{ $book->judul }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label>Tanggal Pinjam</label>
    <input type="date" name="tanggal_pinjam" class="form-control"
        value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam ?? '') }}" required>
</div>

<div class="mb-3">
    <label>Tanggal Kembali</label>
    <input type="date" name="tanggal_kembali" class="form-control"
        value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali ?? '') }}">
</div>

<div class="mb-3">
    <label>Status</label>
    <select name="status" class="form-select" required>
        <option value="dipinjam" {{ old('status', $peminjaman->status ?? '') == 'dipinjam' ? 'selected' : '' }}>
            Dipinjam</option>
        <option value="dikembalikan"
            {{ old('status', $peminjaman->status ?? '') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
    </select>
</div>
