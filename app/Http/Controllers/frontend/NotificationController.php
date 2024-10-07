<?php

namespace App\Http\Controllers\frontend;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\notification;

class NotificationController extends Controller
{
    public function index()
    {
        $idUser = Auth::id();

        $notification = notification::where('id_user', $idUser)
            ->where('read', false)  // Hanya ambil notifikasi yang belum dibaca
            ->orderBy('created_at', 'desc')
            ->get();

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
