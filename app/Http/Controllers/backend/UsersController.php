<?php
namespace App\Http\Controllers\backend;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\user;
use App\Models\pinjambuku;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class UsersController extends Controller
{
    public function index()
    {
        $user = User::whereNotNull('email_verified_at')->get();
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        confirmDelete('Delete', 'Apakah Kamu Yakin?');
        return view('backend.user.index', compact('user', 'notifymenunggu'));
    }

    public function create()
    {
        $notifymenunggu = pinjambuku::whereIn('status', ['menunggu', 'menunggu pengembalian'])->count();

        return view('backend.user.create', compact('notifymenunggu'));
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
        $user->email_verified_at = now();

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

    }

    public function update(Request $request, )
    {

    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $pinjamBukuCount = PinjamBuku::where('id_user', $user->id)
            ->whereIn('status', ['menunggu pengembalian', 'diterima', 'pengembalian ditolak']) // Atau status lain yang sesuai
            ->count();

        if ($pinjamBukuCount > 0) {
            $errorMessages = 'User tidak dapat dihapus karena masih memiliki peminjaman.';

            Alert::error('Gagal', 'Gagal: ' . $errorMessages)->autoClose(2000);

            return redirect()->route('user.index');
        }

        $user->delete();

        Alert::success('Success', 'Data Berhasil Di Hapus')->autoClose(1000);

        return redirect()->route('user.index');
    }

}
