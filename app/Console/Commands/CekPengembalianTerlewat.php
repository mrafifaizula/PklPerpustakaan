<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\pinjambuku;
use Illuminate\Support\Facades\Mail;
use App\Mail\PeringatanPengembalian;
use App\Mail\PeringatanSebelumPengembalian;
use Carbon\Carbon;

class CekPengembalianTerlewat extends Command
{
    protected $signature = 'cek:pengembalian';
    protected $description = 'Cek batas pengembalian yang terlewat dan kirim email notifikasi';

    public function handle()
    {
        $today = Carbon::now()->toDateString();
        $besok = Carbon::now()->addDay()->toDateString();  // Cek 1 hari sebelum batas pengembalian

        // Cek buku yang telah melewati batas pengembalian
        $peminjamansTerlewat = pinjambuku::where('batas_pengembalian', '<', $today)
            ->whereNull('tanggal_pengembalian')
            ->get();

        foreach ($peminjamansTerlewat as $peminjaman) {
            // Kirim email peringatan pengembalian yang terlambat
            Mail::to($peminjaman->user->email)->send(new PeringatanPengembalian($peminjaman));
        }

        // Cek buku yang batas pengembaliannya besok
        $peminjamansBesok = pinjambuku::where('batas_pengembalian', '=', $besok)
            ->whereNull('tanggal_pengembalian')
            ->get();

        foreach ($peminjamansBesok as $peminjaman) {
            // Kirim email pengingat 1 hari sebelum batas pengembalian
            Mail::to($peminjaman->user->email)->send(new PeringatanSebelumPengembalian($peminjaman));
        }

        $this->info('Email peringatan pengembalian dikirim.');
    }
}
