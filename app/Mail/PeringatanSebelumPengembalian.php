<?php
namespace App\Mail;

use App\Models\PeminjamanBuku;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeringatanSebelumPengembalian extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;

    /**
     * Buat instance baru dari mailable.
     *
     * @param PeminjamanBuku $peminjaman
     * @return void
     */
    public function __construct(PeminjamanBuku $peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    /**
     * Membangun pesan email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pengingat: 1 Hari Sebelum Batas Pengembalian Buku')
            ->view('email.1hariSebelumPengembalian')
            ->with('peminjaman', $this->peminjaman);
    }
}
