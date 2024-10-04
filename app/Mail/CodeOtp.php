<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CodeOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $kodeOtp;
    public $user;

    public function __construct($kodeOtp, $user)
    {
        $this->kodeOtp = $kodeOtp;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Verifikasi Kode OTP')
            ->view('email.codeOtp') // Ganti dengan view email yang sesuai
            ->with(['kodeOtp' => $this->kodeOtp, 'user' => $this->user]);
    }
}
