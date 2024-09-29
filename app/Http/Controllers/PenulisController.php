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
        $penulis = penulis::orderBy("id","desc")->get();
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
        return view('backend.penulis.edit', compact('penulis', 'notifymenunggu',));
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
}
