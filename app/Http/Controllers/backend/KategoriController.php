<?php

namespace App\Http\Controllers\backend;

use Validator;
use App\Models\buku;
use App\Models\kategori;
use App\Models\pinjambuku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;


class KategoriController extends Controller
{

    public function index()
    {
        $kategori = kategori::orderBy("id", "desc")->get();
        $buku = buku::all();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.kategori.index', compact('kategori', 'buku', 'notifymenunggu'));
    }

    public function create()
    {
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.kategori.create', compact('notifymenunggu'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required|unique:kategoris,nama_kategori',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            Alert::error('Gagal', 'Gagal: ' . $errorMessages)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $kategori = new kategori();
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(2000);
        return redirect()->route('kategori.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $kategori = kategori::findOrFail($id);
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();


        return view('backend.kategori.edit', compact('kategori', 'notifymenunggu', ));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
        ], [
            'nama_kategori.required' => 'Nama Kategori Harus Diisi',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->first('nama_kategori');
            Alert::error('Gagal', 'Gagal ' . $errors)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kategori = kategori::findOrFail($id);
        $kategori->nama_kategori = $request->nama_kategori;

        $kategori->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(2000);
        return redirect()->route('kategori.index');
    }

    public function destroy($id)
    {
        $kategori = kategori::findOrFail($id);

        if ($kategori->buku()->count() > 0) {
            Alert::error('Error', 'Kategori ini tidak bisa dihapus karena ada buku yang terkait.')->autoClose(2000);
            return redirect()->route('kategori.index');
        }

        $kategori->delete();
        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(2000);
        return redirect()->route('kategori.index');
    }


    public function import()
    {
        $kategori = kategori::all();

        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.kategori.importExcel', compact('kategori', 'notifymenunggu'));
    }


    public function importManual(Request $request)
    {
        $teksKategoris = $request->input('kategoris');
        $kategoriList = array_filter(array_map('trim', explode("\n", $teksKategoris)));

        $kategoriListLower = array_map('strtolower', $kategoriList);

        $kategoriAda = Kategori::whereIn('nama_kategori', $kategoriListLower)->pluck('nama_kategori')->toArray();

        $kategoriDuplikat = array_unique(array_diff_assoc($kategoriListLower, array_unique($kategoriListLower)));

        $kategoriBaru = array_diff($kategoriListLower, $kategoriAda);

        if (!empty($kategoriDuplikat)) {
            Alert::error('Gagal', 'Kategori tidak boleh ada yang sama dalam input.')->autoClose(2000);
        } elseif (!empty($kategoriBaru)) {
            Kategori::insert(array_map(fn($nama) => ['nama_kategori' => $nama, 'created_at' => now(), 'updated_at' => now()], $kategoriBaru));
            Alert::success('Sukses', 'Kategori berhasil disimpan.')->autoClose(2000);
        } else {
            Alert::error('Gagal', 'Semua kategori sudah ada.')->autoClose(2000);
        }

        return redirect()->route('kategori.index');
    }

    public function exportManual()
    {
        $fileName = 'kategori.csv';

        // Data kategori
        $kategoriData = [
            ['Langkah-langkah untuk memasukkan Kategori pada Aplikasi:'],
            ['1. Copy Nama Kategori dari nomber 1 sampe ke bawah'],
            ['2. Paste kategori berikut pada kolom Import Kategori yang telah disediakan di Aplikasi'],
            ['3. Klik Import'],
            [],
            ['Nama Kategori'],
            ['Kategori Contoh 1'],
            ['Kategori Contoh 2'],
            ['Kategori Contoh 3'],
        ];

        // Membuka handle output untuk file CSV
        $handle = fopen('php://output', 'w');

        // Set header untuk file CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Menulis data ke file CSV
        foreach ($kategoriData as $row) {
            fputcsv($handle, $row);
        }

        // Menutup file
        fclose($handle);
        exit;
    }




}
