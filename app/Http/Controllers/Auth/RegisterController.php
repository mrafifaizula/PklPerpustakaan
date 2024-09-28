<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CodeOtp;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail; // Tambahkan ini
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Ubah sesuai rute yang kamu inginkan

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */


    protected function create(array $data)
    {
        // Generate kode OTP 6 digit
        $kodeOtp = rand(100000, 999999);

        // Atur waktu kadaluarsa untuk OTP (berlaku selama 10 menit)
        $kadaluarsaOtp = now()->addMinutes(10);

        // Simpan pengguna beserta kode OTP dan waktu kadaluarsa
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'kode_otp' => $kodeOtp,
            'kadaluarsa_otp' => $kadaluarsaOtp, // Pastikan ini diisi
        ]);

        // Kirim email OTP ke pengguna
        Mail::to($user->email)->send(new CodeOtp($kodeOtp));

        // Simpan email di sesi agar bisa diisi otomatis
        session(['email' => $user->email]);

        // Mengembalikan objek pengguna yang baru dibuat
        return $user;
    }


    protected function registered(Request $request, $user)
    {
        // Arahkan ke halaman verifikasi OTP
        return redirect()->route('otp.verify'); // Ganti dengan nama rute yang benar
    }


}
