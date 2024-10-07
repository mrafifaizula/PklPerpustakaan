<?php

namespace App\Mail;

use App\Models\pinjambuku;
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


    public function __construct(pinjambuku $pinjambuku,)
    {
        $this->pinjambuku = $pinjambuku;
    }

    public function build()
    {
        return $this->subject('Peminjaman Buku Disetujui')
            ->view('email.tolakPinjamBuku')
            ->with([
                'pinjamBuku' => $this->pinjambuku,
                'buku' => $this->buku,
            ]);
    }
}
