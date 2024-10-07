<?php

namespace App\Http\Controllers\frontend;

use Auth;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Notification;
use App\Models\Penulis;
use App\Models\Penerbit;
use App\Models\PinjamBuku;
use App\Models\Testimoni;
use App\Models\User;
use App\Http\Controllers\Controller;


class FrontController extends Controller
{

    // halaman utama

    public function index(Request $request)
    {
        $kategori = Kategori::all();
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $user = Auth::user();
        $pinjambuku = PinjamBuku::all();
        $testimoni = Testimoni::all();


        $buku = Buku::with('Kategori')
            ->where('jumlah_buku', '>', 0)
            ->paginate(6);

        return view('frontend.index', compact('buku', 'kategori', 'penulis', 'penerbit', 'user', 'pinjambuku', 'testimoni'));
    }


    public function detailbuku()
    {
        $buku = buku::all();
        $kategori = kategori::all();
        $penulis = penulis::all();
        $penerbit = penerbit::all();
        $pinjambuku = pinjambuku::all();

        return view('frontend.detailbuku', compact('buku', 'kategori', 'penulis', 'penerbit', 'pinjambuku'));
    }

   

    // profile

    public function perpustakaan()
    {

        if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            return redirect('/email/verify')->with('error', 'Please verify your email first.');
        }

        $buku = buku::take(5)->get();
        $kategori = kategori::all();
        $penulis = penulis::all();
        $penerbit = penerbit::all();
        $user = User::all();
        $idUser = Auth::id();
        $totalpinjam = pinjambuku::where('id_user', $idUser)->sum('jumlah');
       
        $notification = notification::where('id_user', $idUser)
            ->where('read', false)  // Hanya ambil notifikasi yang belum dibaca
            ->orderBy('created_at', 'desc')
            ->get();

        $pinjambuku = pinjambuku::where('id_user', $idUser)
            ->whereIn('status', ['diterima'])
            ->get();

        $jumlahBukuPinjam = pinjambuku::where('id_user', Auth::id())
            ->whereNotIn('status', ['diterima', 'menunggu pengembalian'])
            ->sum('jumlah');

        $userPinjamBuku = pinjambuku::where('id_user', $idUser)
            ->whereIn('status', ['diterima', 'menunggu pengembalian'])
            ->count();

        $totalJumlahBukuDipinjam = pinjambuku::where('id_user', $idUser)
            ->whereIn('status', ['diterima', 'menunggu pengembalian'])
            ->sum('jumlah');


        $pinjamBukuUserTolak = pinjambuku::where('id_user', Auth::id())
            ->whereIn('status', ['ditolak'])
            ->count();

        $pinjamBukuDikembalikan = pinjambuku::where('id_user', Auth::id())
            ->whereIn('status', ['dikembalikan'])
            ->count();

        return view('profil.dashboard', compact('buku', 'kategori', 'penulis', 'penerbit', 'user', 'totalpinjam', 'notification', 'pinjambuku', 'jumlahBukuPinjam', 'userPinjamBuku', 'pinjamBukuUserTolak', 'pinjamBukuDikembalikan', 'totalJumlahBukuDipinjam'));
    }


    public function ShowPinjambuku($id)
    {
        $buku = buku::findOrFail($id);
        $pinjambuku = pinjambuku::where('id_buku', $buku->id)->first();
        $user = Auth::user();
        $idUser = Auth::id();
        $notification = notification::where('id_user', $idUser)
            ->where('read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profil.pinjambuku.pinjamBuku', compact('buku', 'pinjambuku', 'user', 'notification'));
    }


    public function daftarbuku(Request $request)
    {
       
        $buku = Buku::where('jumlah_buku', '>', 0)
            ->paginate(9);

        $idUser = Auth::id();
        $kategori = kategori::all();
        // Ambil notifikasi yang belum dibaca
        $notification = notification::where('id_user', $idUser)
            ->where('read', false)  // Hanya ambil notifikasi yang belum dibaca
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profil.pinjambuku.daftarBuku', compact('buku', 'kategori', 'notification'));
    }

    public function showbukuprofil($id)
    {
        $buku = buku::findorfail($id);
        $pinjambuku = pinjambuku::all();
        $idUser = Auth::id();
        // Ambil notifikasi yang belum dibaca
        $notification = notification::where('id_user', $idUser)
            ->where('read', false)  // Hanya ambil notifikasi yang belum dibaca
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profil.pinjambuku.detailBuku', compact('buku', 'pinjambuku', 'notification'));
    }

    
    public function riwayat()
    {
        $buku = buku::all();
        $user = User::all();
        $pinjambuku = pinjambuku::all();
        $idUser = Auth::id();
        // Ambil notifikasi yang belum dibaca
        $notification = notification::where('id_user', $idUser)
            ->where('read', false)  // Hanya ambil notifikasi yang belum dibaca
            ->orderBy('created_at', 'desc')
            ->get();

        $pinjambuku = pinjambuku::where('id_user', $idUser)
            ->whereIn('status', ['dikembalikan', 'ditolak'])
            ->orderBy('id', 'desc')
            ->get();

        return view('profil.riwayat', compact('pinjambuku', 'buku', 'user', 'notification'));
    }

}
