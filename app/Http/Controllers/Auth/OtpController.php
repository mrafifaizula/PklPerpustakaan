<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

            Alert::success('Success', 'Email berhasil diverifikasi!')->autoClose(2000);
            return redirect()->route('profil.dashboard');
        }

        Alert::error('Error', 'Kode OTP tidak valid atau sudah kadaluarsa.')->autoClose(2000);
        return back()->withInput();
    }


}
