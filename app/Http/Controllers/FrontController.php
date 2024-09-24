<?php

namespace App\Http\Controllers;
use App\Models\buku;
use App\Models\kategori;
use App\Models\penulis;
use App\Models\penerbit;
use App\Models\User;
use App\Models\pinjambuku;
use App\Models\testimoni;
use App\Models\notification;
use Auth;

class FrontController extends Controller
{

    // halaman utama

    public function index()
    {
        $buku = buku::all();
        $kategori = kategori::all();
        $penulis = penulis::all();
        $penerbit = penerbit::all();
        $user = User::all();
        $user = Auth::user();
        $pinjambuku = pinjambuku::all();
        $testimoni = testimoni::all();

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

    public function ShowPinjambuku($id)
    {
        $buku = buku::findOrFail($id);
        $pinjambuku = pinjambuku::where('id_buku', $buku->id)->first();
        $user = Auth::user();
        $idUser = Auth::id();
        $notification = notification::where('id_user', $idUser)
            ->where('read', false)  // Hanya ambil notifikasi yang belum dibaca
            ->orderBy('created_at', 'desc')
            ->get();

        if ($pinjambuku) {
            $totalHarga = $pinjambuku->total_harga;
        } else {
            $totalHarga = 0;
        }



        return view('profil.pinjambuku.pinjamBuku', compact('buku', 'pinjambuku', 'user', 'notification', 'totalHarga'));
    }



    // profile

    public function perpustakaan()
    {
        $buku = buku::all();
        $kategori = kategori::all();
        $penulis = penulis::all();
        $penerbit = penerbit::all();
        $user = User::all();
        $idUser = Auth::id();
        $totalpinjam = pinjambuku::where('id_user', $idUser)->sum('jumlah');
        // Ambil notifikasi yang belum dibaca
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

    public function daftarbuku()
    {
        $buku = buku::all();
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

    public function profil()
    {
        $user = Auth::user();
        $idUser = Auth::id();
        // Ambil notifikasi yang belum dibaca
        $notification = notification::where('id_user', $idUser)
            ->where('read', false)  // Hanya ambil notifikasi yang belum dibaca
            ->orderBy('created_at', 'desc')
            ->get();

        $userPinjamBuku = pinjambuku::where('id_user', Auth::id())
            ->whereIn('status', ['diterima', 'menunggu pengembalian'])
            ->count();

        $jumlahBukuPinjam = pinjambuku::where('id_user', Auth::id())
            ->whereNotIn('status', ['dikembalikan', 'ditolak'])
            ->sum('jumlah');



        return view('profil.profil', compact('user', 'notification', 'userPinjamBuku', 'jumlahBukuPinjam'));
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
