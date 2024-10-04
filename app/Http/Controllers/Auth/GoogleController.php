<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\CodeOtp;
use Illuminate\Support\Facades\Mail;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(uniqid()), // Password acak untuk pengguna baru
                    'kode_otp' => null,
                    'kadaluarsa_otp' => null,
                    'email_verified_at' => now(), // Set waktu verifikasi ke saat ini
                ]);
            } else {
                // Jika pengguna sudah ada, periksa status verifikasi email
                if ($user->email_verified_at) {
                    // Jika sudah terverifikasi, login langsung
                    Auth::login($user, true);
                    return redirect()->route('profil.dashboard'); // Arahkan ke dashboard
                }
            }

            // Jika pengguna sudah terdaftar tetapi belum terverifikasi,
            // arahkan mereka ke halaman verifikasi OTP
            return redirect()->route('otp.verify');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Terjadi masalah saat login menggunakan Google: ' . $e->getMessage());
        }
    }




}
