<?php

namespace App\Http\Controllers\backend;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Buku;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Kontak;
use App\Models\Notification;
use App\Models\Penulis;
use App\Models\Penerbit;
use App\Models\PinjamBuku;
use App\Mail\PengembalianBukuKirimEmail;
use App\Mail\PinjambBukuKirimEmail;
use App\Mail\TolakPinjamKirimEmail;
use App\Mail\TolakPengembalianBuku;
use Carbon\Carbon;

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


        $jmlUser = User::where('role', 'user')
            ->whereNotNull('email_verified_at')
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


        // Tanggal Data harian
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


        return view('backend.dashboard', compact('buku', 'kategori', 'penulis', 'penerbit', 'user', 'notifymenunggu', 'bukuYangDipinjam', 'namaBulan', 'dataDikembalikan', 'jumlahKategori', 'jumlahPenulis', 'jumlahPenerbit', 'jumlahBuku', 'jmlUser', 'tanggalFormat'));
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


    // logika permintaan peminjaman di admin    
    // menyetujui peminjaman
    public function menyetujui($id)
    {
        $pinjambuku = pinjambuku::findOrFail($id);

        if ($pinjambuku->status == 'menunggu') {
            $buku = buku::findOrFail($pinjambuku->id_buku);

            if ($buku->jumlah_buku >= $pinjambuku->jumlah) {
                $buku->jumlah_buku -= $pinjambuku->jumlah;
                $buku->save();

                $pinjambuku->status = 'diterima';
                $pinjambuku->save();

                Mail::to($pinjambuku->user->email)->send(new PinjambBukuKirimEmail($pinjambuku, $buku));

                notification::create([
                    'id_user' => $pinjambuku->id_user,
                    'pesan' => 'Pengajuan peminjaman buku "' . $buku->judul . '" diterima.',
                    'type' => 'peminjaman',
                    'status' => 'diterima',
                ]);

                Alert::success('Sukses', 'Peminjaman buku disetujui.')->autoClose(2000);
            } else {
                Alert::error('Gagal', 'Stok buku tidak mencukupi')->autoClose(2000);
            }
        } else {
            Alert::error('Gagal', 'Pengajuan peminjaman sudah diproses.')->autoClose(2000);
        }

        return redirect()->route('admin.dataPeminjaman.permintaanPeminjaman');
    }

    // tolak peminjaman
    public function tolakpengajuan(Request $request, $id)
    {
        $pinjambuku = pinjambuku::findOrFail($id);

        if (empty($request->input('pesan'))) {
            Alert::error('Gagal', 'Alasan penolakan wajib diisi.')->autoClose(2000);
            return redirect()->back()->with('error', 'Alasan penolakan wajib diisi.');
        }

        if ($pinjambuku->status == 'menunggu') {
            $pesan = $request->input('pesan');
            $pinjambuku->status = 'ditolak';
            $pinjambuku->pesan = $pesan;
            $pinjambuku->save();

            Mail::to($pinjambuku->user->email)->send(new TolakPinjamKirimEmail($pinjambuku));

            notification::create([
                'id_user' => $pinjambuku->id_user,
                'pesan' => 'Pengajuan peminjaman buku "' . $pinjambuku->buku->judul . '" ditolak. Alasan: ' . $pesan,
                'type' => 'peminjaman',
                'status' => 'ditolak',
            ]);

            Alert::success('Sukses', 'Pengajuan telah ditolak.')->autoClose(2000);
            return redirect()->back()->with('message', 'Pengajuan untuk buku "' . $pinjambuku->buku->judul . '" telah ditolak. Alasan: ' . $pesan);
        }

        return redirect()->back()->with('error', 'Pengajuan sudah diproses atau tidak valid.');
    }

    // penolakan pengembalian
    public function tolakpengembalian(Request $request, $id)
    {
        $pinjambuku = Pinjambuku::findOrFail($id);

        if (empty($request->input('pesan'))) {
            Alert::error('Gagal', 'Alasan penolakan wajib diisi.')->autoClose(2000);
            return redirect()->back()->with('error', 'Alasan penolakan wajib diisi.');
        }

        if ($pinjambuku->status == 'menunggu pengembalian') {
            $pesan = $request->input('pesan');
            $pinjambuku->status = 'pengembalian ditolak';
            $pinjambuku->pesan = $pesan;
            $pinjambuku->save();

            Mail::to($pinjambuku->user->email)->send(new TolakPengembalianBuku($pinjambuku));

            // Tambahkan notification
            notification::create([
                'id_user' => $pinjambuku->id_user,
                'pesan' => 'Pemgembalian peminjaman buku "' . $pinjambuku->buku->judul . '" ditolak. Alasan: ' . $pesan,
                'type' => 'pegembalian',
                'status' => 'pengembalian ditolak',
            ]);

            Alert::success('Sukses', 'Pengembalian telah ditolak.')->autoClose(2000);
            return redirect()->back()->with('message', 'Pengembalian untuk buku "' . $pinjambuku->buku->judul . '" telah ditolak. Alasan: ' . $pesan);
        }

        return redirect()->back()->with('error', 'Pengajuan pengembalian sudah diproses atau tidak valid.');
    }

    // terima pengembalian
    public function accpengembalian($id)
    {
        $pinjambuku = pinjambuku::findOrFail($id);

        if ($pinjambuku->status == 'menunggu pengembalian') {
            $buku = buku::findOrFail($pinjambuku->id_buku);
            $buku->jumlah_buku += $pinjambuku->jumlah;
            $buku->save();

            $pinjambuku->status = 'dikembalikan';
            $pinjambuku->save();

            Mail::to($pinjambuku->user->email)->send(new PengembalianBukuKirimEmail($pinjambuku, $buku));

            notification::create([
                'id_user' => $pinjambuku->id_user,
                'pesan' => 'Pengembalian buku "' . $buku->judul . '" berhasil disetujui.',
                'type' => 'pengembalian',
                'status' => 'dikembalikan',
            ]);

            Alert::success('Sukses', 'Pengembalian buku berhasil disetujui.')->autoClose(2000);
        } else {
            Alert::error('Gagal', 'Pengembalian buku tidak dapat diproses.')->autoClose(2000);
        }

        return redirect()->route('admin.dataPeminjaman.permintaanPeminjaman');
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
