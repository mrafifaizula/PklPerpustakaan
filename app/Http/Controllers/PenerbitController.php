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
        $penerbit = penerbit::orderBy("id","desc")->get();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.penerbit.index', compact('penerbit', 'notifymenunggu'));
    }

   
    public function create()
    {
        $notifymenunggu = pinjambuku::where('status', 'menunggu')->count();
        $notifpengajuankembali = pinjambuku::where('status', 'menunggu pengembalian')->count();
   
        return view('backend.penerbit.create', compact('notifymenunggu','notifpengajuankembali'));
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
}
