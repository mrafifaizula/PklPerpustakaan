<?php

namespace App\Http\Controllers;
use App\Models\buku;
use App\Models\kategori;
use App\Models\penulis;
use App\Models\penerbit;
use App\Models\User;
use App\Models\pinjambuku;
use App\Models\kontak;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Http\Request;

class BackController extends Controller
{
    public function index()
    {
        $buku = buku::take(5)->get();
        $kategori = kategori::orderBy("id", "desc")->get();
        $penulis = penulis::all();
        $penerbit = penerbit::all();
        $user = Auth::user();
        $user = User::all();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        $bukuYangDipinjam = pinjambuku::whereIn('status', ['diterima', 'menunggu pengembalian'])
            ->count();


        // chart
        // Ambil data jumlah peminjaman yang sudah dikembalikan per bulan
        $dikembalikan = PinjamBuku::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('count(*) as total'))
            ->where('status', 'dikembalikan')
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Nama bulan
        $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Format data untuk setiap bulan
        $dataDikembalikan = [];
        foreach (range(1, 12) as $bulan) {
            $dataDikembalikan[] = $dikembalikan[$bulan] ?? 0; // Isi dengan 0 jika tidak ada data 'dikembalikan' untuk bulan tersebut
        }



        // chart 2

        $jumlahKategori = Kategori::count();
        $jumlahPenulis = Penulis::count();
        $jumlahPenerbit = Penerbit::count();
        $jumlahBuku = Buku::count();

        return view('backend.dashboard', compact('buku', 'kategori', 'penulis', 'penerbit', 'user', 'notifymenunggu', 'bukuYangDipinjam', 'namaBulan', 'dataDikembalikan', 'jumlahKategori', 'jumlahPenulis', 'jumlahPenerbit', 'jumlahBuku'));
    }

    public function permintaan()
    {
        $pinjambuku = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $buku = Buku::all();
        $user = User::all();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.dataPeminjaman.permintaan', compact('pinjambuku', 'buku', 'user', 'notifymenunggu'));
    }

    public function riwayat()
    {
        $pinjambuku = pinjambuku::whereIn('status', ['dikembalikan', 'ditolak'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $buku = buku::all();
        $user = User::all();

        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.dataPeminjaman.riwayat', compact('pinjambuku', 'buku', 'user', 'notifymenunggu'));
    }


    public function dipinjam()
    {
        $pinjambuku = pinjambuku::whereIn('status', ['diterima', 'pengembalian ditolak'])
            ->orderBy("id", "desc")
            ->get();
        $buku = buku::all();
        $user = User::all();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.dataPeminjaman.daftarBukuDipinjam', compact('pinjambuku', 'buku', 'user', 'notifymenunggu'));
    }

    public function kontak()
    {
        $kontak = kontak::all();
        $user = User::all();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.kontak', compact('kontak', 'user', 'notifymenunggu'));
    }
    
}
