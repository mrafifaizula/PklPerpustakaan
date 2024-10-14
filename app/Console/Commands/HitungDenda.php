<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\pinjambuku; // Pastikan ini adalah path yang benar untuk model Anda
use Carbon\Carbon; // Import Carbon untuk mengelola tanggal

class HitungDenda extends Command
{
    protected $signature = 'hitung:denda';
    protected $description = 'Menghitung denda untuk pinjam buku yang melewati batas pengembalian';

    public function handle()
    {
        $today = Carbon::now(); // Ambil tanggal hari ini
        $pinjambukus = pinjambuku::where('status', 'diterima')->get(); // Ambil semua pinjaman yang statusnya diterima

        $dendaPerBukuPerHari = 2000; // Denda per buku per hari

        if ($pinjambukus->isEmpty()) {
            // Tampilkan pesan jika tidak ada peminjaman yang sedang berjalan
            $this->info('Tidak ada peminjaman buku yang diproses.');
            return;
        }

        $dendaDiperbarui = false; // Melacak apakah ada denda yang diperbarui

        foreach ($pinjambukus as $pinjambuku) {
            // Hitung jumlah hari keterlambatan
            $daysLate = $today->diffInDays($pinjambuku->batas_pengembalian, false); // false untuk memastikan negatif jika belum jatuh tempo

            if ($daysLate > 0) {
                // Hitung denda jika ada keterlambatan
                $denda = $pinjambuku->jumlah * $dendaPerBukuPerHari * $daysLate;
                $pinjambuku->denda = $denda; // Update denda di database
                $dendaDiperbarui = true; // Tandai bahwa ada denda yang diperbarui
            }

            // Simpan perubahan ke database
            $pinjambuku->save();
        }

        // Tampilkan pesan jika ada denda yang diperbarui
        if ($dendaDiperbarui) {
            $this->info('Denda berhasil diperbaharui.');
        } else {
            $this->info('Denda Sudah Diperbaharu.');
        }
    }

}
