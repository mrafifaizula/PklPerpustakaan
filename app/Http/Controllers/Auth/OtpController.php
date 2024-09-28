<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OtpController extends Controller
{
    public function showOtpForm()
    {

        return view('auth.codeOtp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
            'email' => 'required|email',
        ]);

        // Cari pengguna berdasarkan email dan kode OTP
        $user = User::where('email', $request->email)
            ->where('kode_otp', $request->otp)
            ->where('kadaluarsa_otp', '>', now())
            ->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->kode_otp = null;
            $user->kadaluarsa_otp = null;
            $user->save();

            Auth::login($user);

            // Hapus email dari sesi setelah verifikasi
            session()->forget('email');

            return redirect()->route('profil.dashboard')->with('success', 'Email berhasil diverifikasi!');
        }

        return back()->withErrors(['otp' => 'Kode OTP tidak valid atau sudah kadaluarsa.']);
    }

}
