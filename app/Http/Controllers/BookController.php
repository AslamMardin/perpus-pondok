<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookController extends Controller
{
    public function index(Request $request)
    {
         $query = Book::query();

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where('judul', 'like', "%$search%")
              ->orWhere('kategori', 'like', "%$search%");
    }

    $books = $query->orderBy('judul')->get();

    return view('buku.index', compact('books'));
    }
    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
         
            'rak' => 'nullable|string|max:50',
        
        ]);

        Book::create($request->except('_token'));


        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $buku)
    {
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, Book $buku)
    {
        // dd('ok');
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
     
            'rak' => 'nullable|string|max:50',
     
        ]);

        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }


public function showBarcode(Book $buku, Request $request)
{
    $jumlah = $request->get('jumlah', 1); // default 1 jika tidak diisi
    $barcodeSvg = QrCode::size(300)->generate($buku->id);

    return view('buku.barcode-view', compact('buku', 'barcodeSvg', 'jumlah'));
}


public function barcodeSemua()
{
    $books = \App\Models\Book::orderBy('judul')->get();
    return view('buku.barcode-semua', compact('books'));
}




}
