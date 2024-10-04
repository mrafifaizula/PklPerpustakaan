<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\penulis;
use App\Models\pinjambuku;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PenulisController extends Controller
{

    public function index()
    {
        $penulis = penulis::orderBy("id", "desc")->get();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.penulis.index', compact('penulis', 'notifymenunggu'));
    }


    public function create()
    {
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.penulis.create', compact('notifymenunggu'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_penulis' => 'required|unique:penulis,nama_penulis',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            Alert::error('Gagal', 'Gagal: ' . $errorMessages)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // new object
        $penulis = new penulis();
        $penulis->nama_penulis = $request->nama_penulis;
        $penulis->save();

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(2000);
        return redirect()->route('penulis.index');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        $penulis = penulis::findOrFail($id);
        return view('backend.penulis.edit', compact('penulis', 'notifymenunggu', ));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_penulis' => 'required',
        ], [
            'nama_penulis.required' => 'Nama Penulis Harus Diisi',
        ]);

        // validator nama penulis tidak boleh sama pake alert
        if ($validator->fails()) {
            $errors = $validator->errors()->first('nama_penulis');
            Alert::error('Gagal', 'Gagal ' . $errors)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $penulis = penulis::findOrFail($id);
        $penulis->nama_penulis = $request->nama_penulis;

        $penulis->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(2000);
        return redirect()->route('penulis.index');
    }


    public function destroy($id)
    {
        $penulis = penulis::findOrFail($id);

        if ($penulis->buku()->count() > 0) {
            Alert::error('Error', 'Kategori ini tidak bisa dihapus karena ada buku yang terkait.')->autoClose(2000);
            return redirect()->route('kategori.index');
        }

        $penulis->delete();
        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(2000);
        return redirect()->route('penulis.index');
    }


    public function import()
    {
        $penulis = penulis::all();

        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.penulis.importExcel', compact('penulis', 'notifymenunggu'));
    }


    public function importManual(Request $request)
    {
        $tekspenuliss = $request->input('penuliss');
        $penulisList = array_filter(array_map('trim', explode("\n", $tekspenuliss)));

        $penulisListLower = array_map('strtolower', $penulisList);

        $penulisAda = penulis::whereIn('nama_penulis', $penulisListLower)->pluck('nama_penulis')->toArray();

        $penulisDuplikat = array_unique(array_diff_assoc($penulisListLower, array_unique($penulisListLower)));

        $penulisBaru = array_diff($penulisListLower, $penulisAda);

        if (!empty($penulisDuplikat)) {
            Alert::error('Gagal', 'penulis tidak boleh ada yang sama dalam input.')->autoClose(2000);
        } elseif (!empty($penulisBaru)) {
            penulis::insert(array_map(fn($nama) => ['nama_penulis' => $nama, 'created_at' => now(), 'updated_at' => now()], $penulisBaru));
            Alert::success('Sukses', 'penulis berhasil disimpan.')->autoClose(2000);
        } else {
            Alert::error('Gagal', 'Semua penulis sudah ada.')->autoClose(2000);
        }

        return redirect()->route('penulis.index');
    }

    public function exportManual()
    {
        $fileName = 'penulis.csv';

        // Data penulis
        $penulisData = [
            ['Langkah-langkah untuk memasukkan penulis pada Aplikasi:'],
            ['1. Copy Nama penulis dari nomber 1 sampe ke bawah'],
            ['2. Paste penulis berikut pada kolom Import penulis yang telah disediakan di Aplikasi'],
            ['3. Klik Import'],
            [],
            ['Nama Penulis'],
            ['penulis Contoh 1'],
            ['penulis Contoh 2'],
            ['penulis Contoh 3'],
        ];

        // Membuka handle output untuk file CSV
        $handle = fopen('php://output', 'w');

        // Set header untuk file CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Menulis data ke file CSV
        foreach ($penulisData as $row) {
            fputcsv($handle, $row);
        }

        // Menutup file
        fclose($handle);
        exit;
    }
}
