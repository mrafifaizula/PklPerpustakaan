<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use App\Models\Kategori;
use App\Models\Buku;
use App\Models\User;
use Auth;
use Alert;
use Illuminate\Http\Request;

class KontakController extends Controller
{

    public function index()
    {
        $buku = Buku::all();
        $kategori = Kategori::all();
        $totalbuku = Buku::sum('jumlah_buku');
        $user = Auth::user();
        $kontak = Kontak::where('id_user', $user->id)->get();
        return view('frontend.index', compact('kontak', 'kategori', 'buku', 'totalbuku'));
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'pesan' => 'required',
        ]);

        $kontak = new Kontak();
        $kontak->pesan = $request->pesan;
        $kontak->id_user = auth()->id();

        $kontak->save();

        Alert::success('Success', 'Pesan Berhasil Terkirim')->autoClose(1000);
        return redirect()->route('frontend.index')->with('scrollTo', 'contact');

    }




    public function show(kontak $kontak)
    {
        //
    }


    public function edit(kontak $kontak)
    {
        //
    }


    public function update(Request $request, kontak $kontak)
    {
        //
    }


    public function destroy(kontak $kontak)
    {
        //
    }
}
