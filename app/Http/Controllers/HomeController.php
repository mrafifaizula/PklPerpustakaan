<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\buku;
use App\Models\user;
use App\Models\kategori;
use App\Models\penulis;
use App\Models\penerbit;
use App\Models\pinjambuku;
use App\Models\testimoni;
use App\Models\notification;
use Carbon\Carbon;
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
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $user = Auth::user();
        $kategori = Kategori::all();
        $penulis = Penulis::all();
        $penerbit = Penerbit::all();
        $totalbuku = Buku::sum('jumlah_buku');
        $idUser = Auth::id();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();
        $totalpinjam = Pinjambuku::where('id_user', $idUser)->sum('jumlah');

        $buku = Buku::withCount('pinjambuku')
            ->orderBy('pinjambuku_count', 'desc')
            ->take(5)
            ->get();

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


        $jmlUser = User::where('role', 'user')
            ->whereNotNull('email_verified_at')
            ->count();


        // chart 2

        $jumlahKategori = Kategori::count();
        $jumlahPenulis = Penulis::count();
        $jumlahPenerbit = Penerbit::count();
        $jumlahBuku = Buku::count();

        // tanggal 
        $tanggalSekarang = Carbon::now();
        $namaBulanLengkap = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $bulan = $namaBulanLengkap[$tanggalSekarang->month];
        $tanggalFormat = $tanggalSekarang->day . ' ' . $bulan . ' ' . $tanggalSekarang->year;

        $jumlahUserHariIni = user::where('role', 'user')
            ->whereDate('created_at', Carbon::today())
            ->count();


        $jumlahPinjamBukuHariIni = pinjambuku::whereIn('status', ['diterima', 'menunggu pengembalian', 'pengembalian ditolak'])
            ->whereDate('created_at', Carbon::today()) // Menggunakan kolom created_at
            ->count();

        $jumlahPengembalianBukuHariIni = pinjambuku::where('status', ['dikembalikan'])
            ->whereDate('created_at', Carbon::today())
            ->count();

        $jumlahPinjamBukuJatuhTempo = pinjambuku::where('status', '!=', 'dikembalikan')
            ->whereDate('batas_pengembalian', '<', Carbon::today())
            ->count();

        $testimoni = testimoni::all();




        if ($user->role === 'admin') {
            return view('backend.dashboard', compact('buku', 'kategori', 'penulis', 'penerbit', 'totalbuku', 'totalpinjam', 'notifymenunggu', 'userPinjamBuku', 'totalJumlahBukuDipinjam', 'pinjamBukuUserTolak', 'pinjamBukuDikembalikan', 'notification', 'bukuYangDipinjam', 'namaBulan', 'dataDitolak', 'dataDikembalikan', 'jumlahKategori', 'jumlahPenulis', 'jumlahPenerbit', 'jumlahBuku', 'jmlUser', 'tanggalFormat', 'jumlahUserHariIni', 'jumlahPinjamBukuHariIni', 'jumlahPengembalianBukuHariIni', 'jumlahPinjamBukuJatuhTempo', 'testimoni'));
        } elseif ($user->role === 'staf') {
            return view('backend.dashboard', compact('buku', 'kategori', 'penulis', 'penerbit', 'totalbuku', 'totalpinjam', 'notifymenunggu', 'userPinjamBuku', 'totalJumlahBukuDipinjam', 'pinjamBukuUserTolak', 'pinjamBukuDikembalikan', 'notification', 'bukuYangDipinjam', 'namaBulan', 'dataDitolak', 'dataDikembalikan', 'jumlahKategori', 'jumlahPenulis', 'jumlahPenerbit', 'jumlahBuku', 'jmlUser', 'tanggalFormat', 'jumlahUserHariIni', 'jumlahPinjamBukuHariIni', 'jumlahPengembalianBukuHariIni', 'jumlahPinjamBukuJatuhTempo', 'testimoni'));
        } else {
            return view('profil.dashboard', compact('buku', 'kategori', 'penulis', 'penerbit', 'totalbuku', 'totalpinjam', 'notifymenunggu', 'userPinjamBuku', 'totalJumlahBukuDipinjam', 'pinjamBukuUserTolak', 'pinjamBukuDikembalikan', 'notification', 'bukuYangDipinjam', 'namaBulan', 'dataDitolak', 'dataDikembalikan', 'jumlahKategori', 'jumlahPenulis', 'jumlahPenerbit', 'jumlahBuku', 'jmlUser', 'tanggalFormat', 'jumlahUserHariIni', 'jumlahPinjamBukuHariIni', 'jumlahPengembalianBukuHariIni', 'jumlahPinjamBukuJatuhTempo', 'testimoni'));
        }

    }
}
