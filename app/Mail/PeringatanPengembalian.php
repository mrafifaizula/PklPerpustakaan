<?php

namespace App\Mail;

use App\Models\pinjambuku;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeringatanPengembalian extends Mailable
{
    use Queueable, SerializesModels;

    public $peminjaman;

    public function __construct(pinjambuku $peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    public function build()
    {
        return $this->subject('Pengembalian Buku Terlewat Batas')
            ->view('email.terlewatBatasPengembalian')
            ->with('peminjaman', $this->peminjaman);
    }
}
