<?php

namespace App\Mail;

use App\Models\PinjamBuku;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TolakPinjamKirimEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $pinjambuku;
    public $buku;


    public function __construct(PinjamBuku $pinjambuku,)
    {
        $this->pinjambuku = $pinjambuku;
    }

    public function build()
    {
        return $this->subject('Peminjaman Buku Disetujui')
            ->view('email.tolakPengembalianBuku')
            ->with([
                'pinjamBuku' => $this->pinjambuku,
                'buku' => $this->buku,
            ]);
    }
}
