<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodeOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $kodeOtp;

    public function __construct($kodeOtp)
    {
        $this->kodeOtp = $kodeOtp;
    }

    public function build()
    {
        return $this->view('email.codeOtp') // Pastikan ini sesuai dengan nama view yang benar
            ->subject('Kode OTP Verifikasi')
            ->with([
                'kodeOtp' => $this->kodeOtp,
            ]);
    }
}
