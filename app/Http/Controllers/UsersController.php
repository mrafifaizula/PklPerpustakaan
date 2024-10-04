<?php
namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;
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

        return view('backend.user.create', compact('notifymenunggu', 'notifpengajuankembali'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'alamat' => 'nullable|string|max:255',
            'tlp' => 'nullable|string|max:15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|string|max:50',
        ]);

        $user = new user();
        $user->name = $request->name;
        $user->alamat = $request->alamat;
        $user->tlp = $request->tlp;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;

        if ($request->hasFile('image_buku')) {
            $user->deleteImage();
            $img = $request->file('image_user');
            $name = rand(2000, 9999) . $img->getClientOriginalName();
            $img->move('images/user/', $name);
            $user->image_buku = $name;
        }

        $user->save();

        Alert::success('Success', 'Data Berhasil Disimpan')->autoClose(1000);
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }


    public function edit($id)
    {
        $user = user::findOrFail($id);
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();


        return view('backend.user.edit', compact('user', 'notifymenunggu', ));
    }

    public function update(Request $request, $id)
    {
        $user = user::findOrFail($id); // Mengambil pengguna berdasarkan ID

        $validated = $request->validate([
            'name' => 'required|max:255',
            'alamat' => 'nullable|string|max:255',
            'tlp' => 'nullable|string|max:15',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|string|max:50',
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
