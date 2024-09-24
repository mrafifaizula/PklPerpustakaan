<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        $idUser = Auth::id();

        // Ambil notifikasi yang belum dibaca
        $notification = notification::where('id_user', $idUser)
            ->where('read', false)  // Hanya ambil notifikasi yang belum dibaca
            ->orderBy('created_at', 'desc')
            ->get();

        // Kirim notifikasi ke view
        return view('layouts.profil.nav', ['notification' => $notification]);

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function show(notification $notification)
    {
        //
    }


    public function edit(notification $notification)
    {
        //
    }


    public function update(Request $request, notification $notification)
    {
        //
    }


    public function destroy(notification $notification)
    {
        //
    }
}
