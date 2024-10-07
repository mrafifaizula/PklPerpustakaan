<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\CodeOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\Register;
use RealRashid\SweetAlert\Facades\Alert;

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

            session()->forget('email');

            Mail::to($user->email)->send(new Register($user));


            Alert::success('Success', 'Email berhasil diverifikasi!')->autoClose(2000);
            return redirect()->route('profil.dashboard');
        }

        Alert::error('Error', 'Kode OTP tidak valid atau sudah kadaluarsa.')->autoClose(2000);
        return back()->withInput();
    }

    public function mintaUlangOtp(Request $request)
    {
        $email = session('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $kodeOtp = rand(100000, 999999);
            $kadaluarsaOtp = now()->addMinutes(10);

            $user->kode_otp = $kodeOtp;
            $user->kadaluarsa_otp = $kadaluarsaOtp;
            $user->save();

            Mail::to($user->email)->send(new CodeOtp($kodeOtp, $user->name));

            Alert::success('Sukses', 'Kode OTP baru telah dikirim ke email Anda.')->autoClose(2000);
            return back();
        }

        Alert::error('Error', 'Email tidak ditemukan.')->autoClose(2000);
        return back();
    }

}



