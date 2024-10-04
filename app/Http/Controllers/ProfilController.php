<?php

namespace App\Http\Controllers;


use App\Models\kategori;
use App\Models\penulis;
use App\Models\penerbit;
use App\Models\User;
use App\Models\pinjambuku;
use App\Models\testimoni;
use App\Models\notification;
use Illuminate\Http\Request;
use Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $idUser = Auth::id();
        // Ambil notifikasi yang belum dibaca
        $notification = notification::where('id_user', $idUser)
            ->where('read', false)  // Hanya ambil notifikasi yang belum dibaca
            ->orderBy('created_at', 'desc')
            ->get();

        $userPinjamBuku = pinjambuku::where('id_user', Auth::id())
            ->whereIn('status', ['diterima', 'menunggu pengembalian'])
            ->count();

        $jumlahBukuPinjam = pinjambuku::where('id_user', Auth::id())
            ->whereNotIn('status', ['dikembalikan', 'ditolak'])
            ->sum('jumlah');



        return view('profil.profil', compact('user', 'notification', 'userPinjamBuku', 'jumlahBukuPinjam'));
    }

    public function update(Request $request, $id)
    {
        $user = user::findOrFail($id); // Mengambil pengguna berdasarkan ID

        $validated = $request->validate([
            'name' => 'required|max:255',
            'alamat' => 'nullable|string|max:255',
            'tlp' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            // 'password' => 'nullable|min:8|confirmed',
            // 'role' => 'required|string|max:50',
        ]);


        $user = Auth::user();
        $user->name = $request->name;
        $user->tlp = $request->tlp;
        $user->alamat = $request->alamat;

        if ($request->hasFile('image_user')) {
            $img = $request->file('image_user');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/user', $name);
            $user->image_user = $name;
        }

        $user->save();

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(1000);
        return redirect()->route('profil.show')->with('success', 'Profil berhasil diperbarui.');
    }
}

