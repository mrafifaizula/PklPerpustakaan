<?php
namespace App\Http\Controllers;
use Alert;
use Auth;
use App\Models\user;
use App\Models\pinjambuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function index()
    {
        $user = user::all(); // Use plural 'user' for variable name
        $notifymenunggu = pinjambuku::where('status', 'menunggu')->count();
        $notifpengajuankembali = pinjambuku::where('status', 'menunggu pengembalian')->count();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.user.index', compact('user', 'notifymenunggu', 'notifpengajuankembali')); // Compact with plural 'user'
    }

    public function create()
    {
        $notifymenunggu = pinjambuku::where('status', 'menunggu')->count();
        $notifpengajuankembali = pinjambuku::where('status', 'menunggu pengembalian')->count();

        return view('backend.user.create', compact('notifymenunggu', 'notifpengajuankembali'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'alamat' => 'required',
            'tlp' => 'required',
            'email' => 'required|unique:users', // Updated table name to 'users'
            'password' => 'required|min:8',
            'role' => 'required',
        ]);

        $user = new user();
        $user->name = $request->name;
        $user->alamat = $request->alamat;
        $user->tlp = $request->tlp;
        $user->email = $request->email;
        $user->password = Hash::make($request->password); // Correct case 'Hash'
        $user->role = $request->role;

        if ($request->hasFile('image_user')) {
            $img = $request->file('image_user');
            $name = rand(1000, 9999) . $img->getClientOriginalName();
            $img->move('images/user/', $name);
            $user->image_user = $name;
        }

        $user->save();

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(1000);
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }


    public function edit(User $user)
    {

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tlp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'image_user' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
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





    public function destroy($id)
    {
        $user = user::findOrFail($id);
        $user->delete();

        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(1000);
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
