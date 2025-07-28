<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use App\Models\Book;

use App\Imports\BooksImport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BookTemplateExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BookController extends Controller
{
  public function index(Request $request)
{
    $query = Book::query();

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where('judul', 'like', "%$search%");
    }

    $books = $query->orderBy('judul')->get();
    $raks = Rak::orderBy('id')->get(); // Pastikan ada kolom kode di tabel rak
    return view('buku.index', compact('books', 'raks'));
}
    
    public function create()
    {
        return view('buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
         
            'rak_id' => 'nullable|string|max:50',
        
        ]);

        Book::create($request->except('_token'));


        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $buku)
    {
          $raks = Rak::all();
        return view('buku.edit', compact('buku', 'raks'));
    }

    public function update(Request $request, Book $buku)
    {
        // dd('ok');
        $request->validate([
            'judul' => 'required|string|max:255',
     
            'rak_id' => 'nullable|string|max:50',
     
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

  

    return view('buku.barcode-view', compact('buku', 'barcodeSvg', 'jumlah',));
}


public function barcodeSemua()
{
    $books = \App\Models\Book::orderBy('judul')->get();

    return view('buku.barcode-semua', compact('books'));
}

public function downloadTemplate()
    {
        return Excel::download(new BookTemplateExport, 'template-buku.xlsx');
    }
public function importPage()
    {
        return view('buku.importPage');
    }

public function import(Request $request)
{
    // 1. Validasi tipe file
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls'
    ]);

    try {
        // 2. Import langsung dari UploadedFile
        Excel::import(new BooksImport, $request->file('file'));

        return redirect()->back()->with('success', '✅ Data buku berhasil diimpor!');
    } catch (\Throwable $e) {
        // 3. Log error untuk debugging
        Log::error('Import Buku Gagal: ' . $e->getMessage());

        return redirect()->back()->with('error', '❌ Import gagal: ' . $e->getMessage());
    }
}





}
