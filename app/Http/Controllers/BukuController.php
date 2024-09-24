<?php

namespace App\Http\Controllers;
use Validator;
use Alert;
use App\Models\buku;
use App\Models\kategori;
use App\Models\penulis;
use App\Models\penerbit;
use App\Models\pinjambuku;
use Illuminate\Http\Request;

class BukuController extends Controller
{

    public function index()
    {
        $buku = buku::orderBy("id", "desc")->get();
        $kategori = kategori::all();
        $penulis = penulis::all();
        $penerbit = penerbit::all();
        $pinjambuku = pinjambuku::all();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('admin.buku.index', compact('kategori', 'penulis', 'penerbit', 'pinjambuku', 'buku', 'notifymenunggu'));

    }


    public function create()
    {
        $buku = buku::all();
        $kategori = kategori::all();
        $penulis = penulis::all();
        $penerbit = penerbit::all();
        $pinjambuku = pinjambuku::all();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('admin.buku.create', compact('buku', 'kategori', 'penulis', 'penerbit', 'pinjambuku', 'notifymenunggu'));
    }


    public function store(Request $request)
    {
        $request->merge([
            'harga' => str_replace(['Rp ', '.'], '', $request->harga)
        ]);

        $validator = Validator::make($request->all(), [
            'judul' => 'required|unique:bukus,judul',
            'jumlah_buku' => 'required',
            'tahun_terbit' => 'required|date',
            'desc_buku' => 'required',
            'code_buku' => 'required',
            'harga' => 'required|numeric',
            'id_kategori' => 'required',
            'id_penulis' => 'required',
            'id_penerbit' => 'required',
            'image_buku' => 'required|max:4000|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            Alert::error('Gagal', 'Gagal: ' . $errorMessages)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $hargaFormatted = str_replace(['Rp ', '.'], '', $request->harga);

        $buku = new buku();
        $buku->judul = $request->judul;
        $buku->jumlah_buku = $request->jumlah_buku;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->desc_buku = $request->desc_buku;
        $buku->code_buku = $request->code_buku;
        $buku->harga = $hargaFormatted;
        $buku->id_kategori = $request->id_kategori;
        $buku->id_penulis = $request->id_penulis;
        $buku->id_penerbit = $request->id_penerbit;

        if ($request->hasFile('image_buku')) {
            $img = $request->file('image_buku');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/buku/', $name);
            $buku->image_buku = $name;
        }

        $buku->save();
        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(1000);
        return redirect()->route('buku.index');
    }


    public function show($id)
    {
        $buku = buku::findorfail($id);
        $pinjambuku = pinjambuku::all();
        $notifymenunggu = pinjambuku::where('status', ['menunggu', 'menunggu pengembalian'])->count();
        return view('frontend.detailbuku', compact('buku', 'pinjambuku', 'notifymenunggu'));
    }


    public function edit($id)
    {
        $buku = buku::findOrFail($id);
        $kategori = kategori::all();
        $penulis = penulis::all();
        $penerbit = penerbit::all();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('admin.buku.edit', compact('buku', 'kategori', 'penulis', 'penerbit', 'notifymenunggu'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'judul' => 'required',
                'jumlah_buku' => 'required',
                'tahun_terbit' => 'required|date',
                'desc_buku' => 'required',
                'code_buku' => 'required',
                'harga' => 'required',
                'id_kategori' => 'required',
                'id_penulis' => 'required',
                'id_penerbit' => 'required',
                // 'image_buku' => 'required|max:4000|mimes:jpeg,png,jpg,gif,svg',
            ]
        );

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            Alert::error('Gagal', 'Gagal: ' . $errorMessages)->autoClose(2000);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $buku = buku::findOrFail($id);
        $buku->judul = $request->judul;
        $buku->jumlah_buku = $request->jumlah_buku;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->desc_buku = $request->desc_buku;
        $buku->code_buku = $request->code_buku;
        $buku->harga = str_replace(['Rp', '.', ','], ['', '', '.'], $request->harga);
        $buku->id_kategori = $request->id_kategori;
        $buku->id_penulis = $request->id_penulis;
        $buku->id_penerbit = $request->id_penerbit;

        if ($request->hasFile('image_buku')) {
            $buku->deleteImage(); // Deletes the old image if it exists
            $img = $request->file('image_buku'); // Get the uploaded file
            $name = rand(1000, 9999) . $img->getClientOriginalName(); // Generate a unique filename
            $img->move('images/buku/', $name); // Move the file to the specified directory
            $buku->image_buku = $name; // Save the new filename in the model
        }        

        $buku->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(1000);
        return redirect()->route('buku.index');
    }


    

    public function destroy($id)
    {
        $buku = buku::findOrFail($id);
        $buku->delete();
        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(1000);
        return redirect()->route('buku.index');
    }
}
