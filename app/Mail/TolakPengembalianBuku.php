<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\pinjambuku;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TolakPengembalianBuku extends Mailable
{
    use Queueable, SerializesModels;

    public $pinjambuku;
    public $buku;


    public function __construct(pinjambuku $pinjambuku )
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
