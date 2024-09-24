<?php

namespace App\Http\Controllers;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $chat = Chat::create([
            'id_user' => auth()->id(),
            'message' => $request->input('message')
        ]);
        return response()->json($chat);
    }

    public function index()
    {
        return Chat::with('user')->latest()->take(50)->get();
    }
}
