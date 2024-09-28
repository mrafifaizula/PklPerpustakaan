<?php
namespace App\Mail;

use App\Models\PinjamBuku;
use App\Models\Buku;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PinjambBukuKirimEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pinjambuku;
    public $buku;


    public function __construct(PinjamBuku $pinjambuku, Buku $buku)
    {
        $this->pinjambuku = $pinjambuku;
        $this->buku = $buku;
    }

    public function build()
    {
        return $this->subject('Peminjaman Buku Disetujui')
            ->view('email.menyetujuiPeminjaman')
            ->with([
                'pinjamBuku' => $this->pinjambuku,
                'buku' => $this->buku,
            ]);
    }
}
