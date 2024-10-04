<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\pinjambuku;
use App\Models\penerbit;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PenerbitController extends Controller
{

    public function index()
    {
        $penerbit = penerbit::orderBy("id", "desc")->get();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.penerbit.index', compact('penerbit', 'notifymenunggu'));
    }


    public function create()
    {
        $notifymenunggu = pinjambuku::where('status', 'menunggu')->count();
        $notifpengajuankembali = pinjambuku::where('status', 'menunggu pengembalian')->count();

        return view('backend.penerbit.create', compact('notifymenunggu', 'notifpengajuankembali'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_penerbit' => 'required|unique:penerbits,nama_penerbit',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            Alert::error('Gagal', 'Gagal: ' . $errorMessages)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $penerbit = new penerbit();
        $penerbit->nama_penerbit = $request->nama_penerbit;
        $penerbit->save();

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(2000);
        return redirect()->route('penerbit.index');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $penerbit = penerbit::findOrFail($id);
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.penerbit.edit', compact('penerbit', 'notifymenunggu'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_penerbit' => 'required',
        ], [
            'nama_penerbit.required' => 'Nama Penerbit Harus Diisi',
        ]);

        // validator nama penerbit tidak boleh sama pake alert
        if ($validator->fails()) {
            $errors = $validator->errors()->first('nama_penerbit');
            Alert::error('Gagal', 'Gagal ' . $errors)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $penerbit = penerbit::findOrFail($id);
        $penerbit->nama_penerbit = $request->nama_penerbit;

        $penerbit->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(2000);
        return redirect()->route('penerbit.index');
    }


    public function destroy($id)
    {
        $penerbit = penerbit::findOrFail($id);

        if ($penerbit->buku()->count() > 0) {
            Alert::error('Error', 'Kategori ini tidak bisa dihapus karena ada buku yang terkait.')->autoClose(2000);
            return redirect()->route('kategori.index');
        }

        $penerbit->delete();
        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(2000);
        return redirect()->route('penerbit.index');
    }


    public function import()
    {
        $penerbit = penerbit::all();

        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.penerbit.importExcel', compact('penerbit', 'notifymenunggu'));
    }


    public function importManual(Request $request)
    {
        $tekspenerbits = $request->input('penerbits');
        $penerbitList = array_filter(array_map('trim', explode("\n", $tekspenerbits)));

        $penerbitListLower = array_map('strtolower', $penerbitList);

        $penerbitAda = penerbit::whereIn('nama_penerbit', $penerbitListLower)->pluck('nama_penerbit')->toArray();

        $penerbitDuplikat = array_unique(array_diff_assoc($penerbitListLower, array_unique($penerbitListLower)));

        $penerbitBaru = array_diff($penerbitListLower, $penerbitAda);

        if (!empty($penerbitDuplikat)) {
            Alert::error('Gagal', 'penerbit tidak boleh ada yang sama dalam input.')->autoClose(2000);
        } elseif (!empty($penerbitBaru)) {
            penerbit::insert(array_map(fn($nama) => ['nama_penerbit' => $nama, 'created_at' => now(), 'updated_at' => now()], $penerbitBaru));
            Alert::success('Sukses', 'penerbit berhasil disimpan.')->autoClose(2000);
        } else {
            Alert::error('Gagal', 'Semua penerbit sudah ada.')->autoClose(2000);
        }

        return redirect()->route('penerbit.index');
    }

    public function exportManual()
    {
        $fileName = 'penerbit.csv';

        // Data penerbit
        $penerbitData = [
            ['Langkah-langkah untuk memasukkan penerbit pada Aplikasi:'],
            ['1. Copy Nama penerbit dari nomber 1 sampe ke bawah'],
            ['2. Paste penerbit berikut pada kolom Import penerbit yang telah disediakan di Aplikasi'],
            ['3. Klik Import'],
            [],
            ['Nama Penerbit'],
            ['penerbit Contoh 1'],
            ['penerbit Contoh 2'],
            ['penerbit Contoh 3'],
        ];

        // Membuka handle output untuk file CSV
        $handle = fopen('php://output', 'w');

        // Set header untuk file CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Menulis data ke file CSV
        foreach ($penerbitData as $row) {
            fputcsv($handle, $row);
        }

        // Menutup file
        fclose($handle);
        exit;
    }
}
