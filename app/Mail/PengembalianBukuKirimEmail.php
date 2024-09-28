<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\PinjamBuku;
use App\Models\Buku;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengembalianBukuKirimEmail extends Mailable
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
            ->view('email.menyetujuiPengembalian')
            ->with([
                'pinjamBuku' => $this->pinjambuku,
                'buku' => $this->buku,
            ]);
    }

    
}
