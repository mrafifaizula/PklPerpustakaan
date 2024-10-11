<?php
namespace App\Http\Controllers\frontend;

use Auth;
use App\Models\Favorit;
use App\Models\Buku;
use App\Models\user;
use App\Models\Kategori;
use App\Models\Notification;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log; // Pastikan ini ada
use App\Http\Controllers\Controller;

class FavoritController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $buku = $user->favorit;

        $kategori = Kategori::all();
        $notification = Notification::where('id_user', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profil.bukuFavorit', compact('buku', 'kategori', 'notification'));
    }



    public function tambahKeFavorit($id)
    {
        $user = Auth::user();
        $buku = Buku::findOrFail($id);

        if ($user->favorit()->where('id_buku', $buku->id)->exists()) {
            Alert::error('Error', 'Buku sudah ada di favorit Anda.')->autoClose(2000);
            return redirect()->back();
        }

        $user->favorit()->attach($buku->id);

        Alert::success('Success', 'Buku berhasil ditambahkan ke favorit!')->autoClose(2000);
        return redirect()->back();
    }


    public function hapusDariFavorit($id)
    {
        $user = Auth::user();
        $buku = buku::findOrFail($id);

        if (!$user->favorit()->where('id_buku', $buku->id)->exists()) {
            Alert::error('error', 'Buku tidak ditemukan di favorit Anda.')->autoClose(2000);
            return redirect()->back();
        }

        $user->favorit()->detach($buku->id);

        Alert::success('success', 'Buku berhasil dihapus dari favorit!')->autoClose(2000);
        return redirect()->back();
    }





}
