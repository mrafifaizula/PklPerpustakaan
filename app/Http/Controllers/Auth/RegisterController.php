<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\CodeOtp;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        $kodeOtp = rand(100000, 999999);
        $kadaluarsaOtp = now()->addMinutes(10);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'kode_otp' => $kodeOtp,
            'kadaluarsa_otp' => $kadaluarsaOtp,
        ]);

        Mail::to($user->email)->send(new CodeOtp($kodeOtp));
        session(['email' => $user->email]);

        return $user;
    }


    protected function registered(Request $request, $user)
    {
        return redirect()->route('otp.verify');
    }


    public function mintaUlangOtp(Request $request)
    {
        $email = session('email');
        $pengguna = User::where('email', $email)->first();

        if ($pengguna) {
            $kodeOtp = rand(100000, 999999);
            $kadaluarsaOtp = now()->addMinutes(10);

            $pengguna->kode_otp = $kodeOtp;
            $pengguna->kadaluarsa_otp = $kadaluarsaOtp;
            $pengguna->save();

            Mail::to($pengguna->email)->send(new CodeOtp($kodeOtp));

            Alert::success('Sukses', 'Kode OTP baru telah dikirim ke email Anda.')->autoClose(2000);
            return back();
        }

        // Jika pengguna tidak ditemukan, tampilkan pesan error
        Alert::error('Error', 'Email tidak ditemukan.')->autoClose(2000);
        return back();
    }


}
