<?php

namespace App\Http\Controllers;

use App\Mail\PengembalianBukuKirimEmail;
use App\Mail\PinjambBukuKirimEmail;
use App\Mail\TolakPinjamKirimEmail;
use App\Models\pinjambuku;
use App\Models\buku;
use App\Models\User;
use App\Models\kategori;
use App\Models\penulis;
use App\Models\penerbit;
use App\Models\notification;
use Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class PinjambukuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $buku = buku::all();
        $kategori = kategori::all();
        $penulis = penulis::all();
        $penerbit = penerbit::all();
        $pinjambuku = pinjambuku::where('id_user', $user->id)
            ->whereIn('status', ['menunggu', 'diterima', 'menunggu pengembalian', 'pengembalian ditolak'])
            ->orderBy('updated_at', 'desc')
            ->get();

        $idUser = Auth::id();
        $notification = notification::where('id_user', $idUser)
            ->where('read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profil.peminjamanBuku', compact('buku', 'kategori', 'penulis', 'penerbit', 'user', 'pinjambuku', 'notification'));
    }


    public function create()
    {
        $pinjambuku = pinjambuku::all();
        $buku = buku::all();
        $user = User::all();
        return view('profil.pinjambuku', compact('pinjambuku', 'buku', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric',
            'tanggal_pinjambuku' => 'required|date',
            'batas_pengembalian' => 'required|date',
            'id_buku' => 'required|numeric',
            'id_user' => 'required|numeric',
        ]);

        $buku = buku::findOrFail($request->id_buku);

        if ($request->jumlah > $buku->jumlah_buku) {
            Alert::error('Gagal', 'Stok buku tidak mencukupi.')->autoClose(2000);
            return redirect()->back()->with('error', 'Stok buku tidak mencukupi.');
        }

        $judulTidakBolehSama = pinjambuku::where('id_user', $request->id_user)
            ->where('id_buku', $request->id_buku)
            ->whereIn('status', ['menunggu', 'diterima', 'menunggu pengembalian'])
            ->exists();

        if ($judulTidakBolehSama) {
            Alert::error('Gagal', 'Anda tidak dapat meminjam buku ini karena masih ada peminjaman aktif.')->autoClose(2000);
            return redirect()->back()->with('error', 'Anda tidak dapat meminjam buku ini karena masih ada peminjaman aktif.');
        }

        $pinjamjudul = pinjambuku::where('id_user', $request->id_user)
            ->where('id_buku', $request->id_buku)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($pinjamjudul) {
            if ($pinjamjudul->status == 'menunggu') {
                Alert::info('InfoAlert', 'Peminjaman buku ini masih dalam proses persetujuan.')->autoClose(2000);
                return redirect()->back()->with('error', 'Peminjaman buku ini masih dalam proses persetujuan.');
            } elseif ($pinjamjudul->status == 'diterima') {
                Alert::error('Gagal', 'Anda masih meminjam buku ini.')->autoClose(2000);
                return redirect()->back()->with('error', 'Anda masih meminjam buku ini.');
            } elseif ($pinjamjudul->status == 'dikembalikan') {
                Alert::info('Info', 'Buku ini sudah dikembalikan. Anda bisa meminjam lagi.')->autoClose(2000);
            }
        }

        $pinjambuku = new pinjambuku();
        $pinjambuku->jumlah = $request->jumlah;
        $pinjambuku->tanggal_pinjambuku = $request->tanggal_pinjambuku;
        $pinjambuku->batas_pengembalian = Carbon::now()->addDays(7);
        $pinjambuku->status = 'menunggu';
        $pinjambuku->id_buku = $request->id_buku;
        $pinjambuku->id_user = $request->id_user;

        $pinjambuku->save();

        Alert::success('Success', 'Permintaan peminjaman buku berhasil dibuat. Menunggu persetujuan.')->autoClose(2000);
        return redirect()->route('profil.peminjamanBuku');
    }

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




    // batalpengajuan
    public function batalkanpengajuan($id)
    {
        $item = pinjambuku::findOrFail($id);

        if ($item->status === 'menunggu') {
            $item->status = 'dibatalkan';
            $item->save();

            Alert::success('Sukses', 'Pengajuan berhasil dibatalkan.')->autoClose(2000);
            return redirect()->back()->with('success', 'Pengajuan berhasil dibatalkan.');
        }

        Alert::error('Gagal', 'Pengajuan tidak dapat dibatalkan.')->autoClose(2000);
        return redirect()->back()->with('error', 'Pengajuan tidak dapat dibatalkan.');
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



    // ajukan pengembalian
    public function ajukanpengembalian($id)
    {
        $pinjambuku = pinjambuku::findOrFail($id);

        if ($pinjambuku->status == 'diterima' || $pinjambuku->status == 'pengembalian ditolak') {
            $pinjambuku->status = 'menunggu pengembalian';
            $pinjambuku->save();

            Alert::success('Sukses', 'Permintaan pengembalian berhasil diajukan. Tunggu persetujuan admin.')->autoClose(2000);
        } else {
            Alert::error('Gagal', 'Pengajuan peminjaman belum disetujui, buku tidak dapat dikembalikan.')->autoClose(2000);
        }

        return redirect()->route('profil.peminjamanBuku');
    }



    // batalkan pengembalian
    public function batalkanpengajuanpengembalian($id)
    {
        $pinjambuku = pinjambuku::findOrFail($id);

        if ($pinjambuku->status == 'menunggu pengembalian') {
            $pinjambuku->status = 'diterima';
            $pinjambuku->save();

            Alert::success('Sukses', 'Pengajuan pengembalian berhasil dibatalkan.')->autoClose(2000);
        } else {
            Alert::error('Gagal', 'Pengajuan pengembalian tidak dapat dibatalkan.')->autoClose(2000);
        }

        return redirect()->route('profil.peminjamanBuku');
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


    // mnerima pengembalian
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


}