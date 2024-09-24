<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penulis;
use App\Models\Penerbit;
use App\Models\Pinjambuku;
use App\Models\notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = Auth::user();
        $buku = Buku::all();
        $kategori = Kategori::all();
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $totalbuku = Buku::sum('jumlah_buku');
        $idUser = Auth::id();
        $notifymenunggu = Pinjambuku::where('status', 'menunggu')->count();
        $notifpengajuankembali = Pinjambuku::where('status', 'menunggu pengembalian')->count();
        $totalpinjam = Pinjambuku::where('id_user', $idUser)->sum('jumlah');

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

        $notification = notification::where('id_user', $idUser)
            ->where('read', false)  // Hanya ambil notifikasi yang belum dibaca
            ->orderBy('created_at', 'desc')
            ->get();

        $bukuYangDipinjam = pinjambuku::whereIn('status', ['diterima', 'menunggu pengembalian'])
            ->count();

        $dikembalikan = PinjamBuku::select(DB::raw('MONTH(created_at) as bulan'), DB::raw('count(*) as total'))
            ->where('status', 'dikembalikan')
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        // Format data untuk setiap bulan
        $dataDitolak = [];
        $dataDikembalikan = [];
        foreach (range(1, 12) as $bulan) {
            $dataDitolak[] = $ditolak[$bulan] ?? 0; // Isi dengan 0 jika tidak ada data 'ditolak' untuk bulan tersebut
            $dataDikembalikan[] = $dikembalikan[$bulan] ?? 0; // Isi dengan 0 jika tidak ada data 'dikembalikan' untuk bulan tersebut
        }


        // chart 2

        $jumlahKategori = Kategori::count();
        $jumlahPenulis = Penulis::count();
        $jumlahPenerbit = Penerbit::count();
        $jumlahBuku = Buku::count();


        $users = Auth::user();
        if ($users->isAdmin == 1) {
            return view('admin.dashboard', compact('buku', 'kategori', 'penulis', 'penerbit', 'totalbuku', 'totalpinjam', 'notifymenunggu', 'notifpengajuankembali', 'userPinjamBuku', 'totalJumlahBukuDipinjam', 'pinjamBukuUserTolak', 'pinjamBukuDikembalikan', 'notification', 'bukuYangDipinjam', 'namaBulan', 'dataDitolak', 'dataDikembalikan', 'jumlahKategori', 'jumlahPenulis', 'jumlahPenerbit', 'jumlahBuku'));
        } else {
            return view('profil.dashboard', compact('buku', 'kategori', 'penulis', 'penerbit', 'totalbuku', 'totalpinjam', 'notifymenunggu', 'notifpengajuankembali', 'userPinjamBuku', 'totalJumlahBukuDipinjam', 'pinjamBukuUserTolak', 'pinjamBukuDikembalikan', 'notification', 'bukuYangDipinjam', 'namaBulan', 'dataDitolak', 'dataDikembalikan', 'jumlahKategori', 'jumlahPenulis', 'jumlahPenerbit', 'jumlahBuku'));
        }
        return view('profil.dashboard', compact('buku', 'kategori', 'penulis', 'penerbit', 'totalbuku', 'totalpinjam', 'notifymenunggu', 'notifpengajuankembali', 'userPinjamBuku', 'totalJumlahBukuDipinjam', 'pinjamBukuUserTolak', 'pinjamBukuDikembalikan', 'notification', 'bukuYangDipinjam', 'namaBulan', 'dataDitolak', 'dataDikembalikan', 'jumlahKategori', 'jumlahPenulis', 'jumlahPenerbit', 'jumlahBuku'));


    }
}
