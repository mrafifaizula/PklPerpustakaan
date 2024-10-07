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
                    'password' => bcrypt(uniqid()),
                    'email_verified_at' => now(),
                ]);
            }

            // Login pengguna (baik yang baru maupun yang sudah ada)
            Auth::login($user, true);

            return redirect()->route('profil.dashboard');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Terjadi masalah saat login menggunakan Google.');
        }
    }



}
