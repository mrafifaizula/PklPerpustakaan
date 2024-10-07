<?php

namespace App\Http\Controllers\backend;
use Auth;
use Validator;
use App\Models\buku;
use App\Models\kategori;
use App\Models\penulis;
use App\Models\penerbit;
use App\Models\pinjambuku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

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

        return view('backend.buku.index', compact('kategori', 'penulis', 'penerbit', 'pinjambuku', 'buku', 'notifymenunggu'));

    }


    public function create()
    {
        $buku = buku::all();
        $kategori = kategori::all();
        $penulis = penulis::all();
        $penerbit = penerbit::all();
        $pinjambuku = pinjambuku::all();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.buku.create', compact('buku', 'kategori', 'penulis', 'penerbit', 'pinjambuku', 'notifymenunggu'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|unique:bukus,judul',
            'jumlah_buku' => 'required',
            'tahun_terbit' => 'required',
            'desc_buku' => 'required',
            'code_buku' => 'required',
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


        $buku = new buku();
        $buku->judul = $request->judul;
        $buku->jumlah_buku = $request->jumlah_buku;
        $buku->tahun_terbit = $request->tahun_terbit;
        $buku->desc_buku = $request->desc_buku;
        $buku->code_buku = $request->code_buku;
        $buku->id_kategori = $request->id_kategori;
        $buku->id_penulis = $request->id_penulis;
        $buku->id_penerbit = $request->id_penerbit;

        if ($request->hasFile('image_buku')) {
            $img = $request->file('image_buku');
            $name = rand(2000, 9999) . $img->getClientOriginalName();
            $img->move('images/buku/', $name);
            $buku->image_buku = $name;
        }

        $buku->save();
        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(2000);
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

        return view('backend.buku.edit', compact('buku', 'kategori', 'penulis', 'penerbit', 'notifymenunggu'));
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'judul' => 'required',
                'jumlah_buku' => 'required',
                'tahun_terbit' => 'required',
                'desc_buku' => 'required',
                'code_buku' => 'required',
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
        $buku->id_kategori = $request->id_kategori;
        $buku->id_penulis = $request->id_penulis;
        $buku->id_penerbit = $request->id_penerbit;

        if ($request->hasFile('image_buku')) {
            $buku->deleteImage();
            $img = $request->file('image_buku');
            $name = rand(2000, 9999) . $img->getClientOriginalName();
            $img->move('images/buku/', $name);
            $buku->image_buku = $name;
        }

        $buku->save();
        Alert::success('Success', 'Data Berhasil Diubah')->autoClose(2000);
        return redirect()->route('buku.index');
    }


    public function destroy($id)
    {
        $buku = buku::findOrFail($id);
        $buku->delete();
        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(2000);
        return redirect()->route('buku.index');
    }


    public function import()
    {
        $buku = buku::all();

        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.buku.importExcel', compact('buku', 'notifymenunggu'));
    }


    public function importManual(Request $request)
    {
        // Ambil input data buku dari textarea
        $teksBukus = $request->input('bukus');

        // Setiap baris input dipecah per buku
        $bukuList = array_filter(array_map('trim', explode("\n", $teksBukus)));

        $bukuData = [];

        // Format input setiap buku: judul, tahun_terbit, jumlah_buku, image_buku, desc_buku, code_buku, nama_kategori, nama_penulis, nama_penerbit
        foreach ($bukuList as $buku) {
            // Pecah setiap baris berdasarkan koma untuk mendapatkan data buku
            $bukuDetail = array_map('trim', explode(",", $buku));

            if (count($bukuDetail) === 9) {  // Pastikan ada 9 elemen per buku
                // Mencari ID berdasarkan nama kategori, penulis, dan penerbit
                $idKategori = Kategori::where('nama_kategori', $bukuDetail[6])->value('id');
                $idPenulis = Penulis::where('nama_penulis', $bukuDetail[7])->value('id');
                $idPenerbit = Penerbit::where('nama_penerbit', $bukuDetail[8])->value('id');

                // Jika salah satu ID tidak ditemukan, tampilkan pesan kesalahan
                if (!$idKategori || !$idPenulis || !$idPenerbit) {
                    Alert::error('Gagal', 'Salah satu kategori, penulis, atau penerbit tidak ditemukan.')->autoClose(2000);
                    return redirect()->back();
                }

                $bukuData[] = [
                    'judul' => $bukuDetail[0],
                    'tahun_terbit' => $bukuDetail[1],
                    'jumlah_buku' => $bukuDetail[2],
                    'image_buku' => $bukuDetail[3],
                    'desc_buku' => $bukuDetail[4],
                    'code_buku' => $bukuDetail[5],
                    'id_kategori' => $idKategori,
                    'id_penulis' => $idPenulis,
                    'id_penerbit' => $idPenerbit,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            } else {
                Alert::error('Gagal', 'Format data buku salah. Pastikan semua kolom terisi.')->autoClose(2000);
                return redirect()->back();
            }
        }

        // Ambil judul buku yang sudah ada di database
        $judulBukuAda = Buku::whereIn('judul', array_column($bukuData, 'judul'))->pluck('judul')->toArray();

        // Pisahkan buku baru yang belum ada di database
        $bukuBaru = array_filter($bukuData, fn($buku) => !in_array(strtolower($buku['judul']), $judulBukuAda));

        if (!empty($bukuBaru)) {
            Buku::insert($bukuBaru);
            Alert::success('Sukses', 'Buku berhasil disimpan.')->autoClose(2000);
        } else {
            Alert::error('Gagal', 'Semua buku sudah ada atau format salah.')->autoClose(2000);
        }

        return redirect()->route('buku.index');
    }

    public function exportManual()
    {
        $fileName = 'buku.csv';

        // Data buku dengan setiap elemen dalam kolom yang terpisah
        $bukuData = [
            ['Judul', 'Tahun Terbit', 'Jumlah Buku', 'Image Buku', 'Deskripsi Buku', 'Code Buku', 'Nama Kategori', 'Nama Penulis', 'Nama Penerbit'],
            ['Buku Contoh 1', '2024', '10', 'image1.jpg', 'Deskripsi Buku Contoh 1', 'CODE1', 'Kategori 1', 'Penulis 1', 'Penerbit 1'],
            ['Buku Contoh 2', '2023', '5', 'image2.jpg', 'Deskripsi Buku Contoh 2', 'CODE2', 'Kategori 2', 'Penulis 2', 'Penerbit 2'],
            ['Buku Contoh 3', '2022', '8', 'image3.jpg', 'Deskripsi Buku Contoh 3', 'CODE3', 'Kategori 3', 'Penulis 3', 'Penerbit 3'],
        ];

        // Membuka handle output untuk file CSV
        $handle = fopen('php://output', 'w');

        // Set header untuk file CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Menulis data ke file CSV
        foreach ($bukuData as $row) {
            fputcsv($handle, $row); // Setiap baris ditulis ke CSV dengan fputcsv
        }

        // Menutup file
        fclose($handle);
        exit;
    }


}
