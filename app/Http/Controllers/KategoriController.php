<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\kategori;
use App\Models\buku;
use App\Models\pinjambuku;
use Validator;
use App\Imports\KategoriImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

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

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(1000);
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

        // validator nama kategori tidak boleh sama pake alert
        if ($validator->fails()) {
            $errors = $validator->errors()->first('nama_kategori');
            Alert::error('Gagal', 'Gagal ' . $errors)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $kategori = kategori::findOrFail($id);
        $kategori->nama_kategori = $request->nama_kategori;

        $kategori->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(1000);
        return redirect()->route('kategori.index');
    }

    public function destroy($id)
    {
        $kategori = kategori::findOrFail($id);
        $kategori->delete();
        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(1000);
        return redirect()->route('kategori.index');
    }

    public function import(Request $request) 
    {
        // Validasi file Excel
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        // Proses import file Excel
        Excel::import(new KategoriImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data kategori berhasil diimport!');
    }

}
