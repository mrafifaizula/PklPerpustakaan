<?php


use App\Http\Controllers\FrontController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PinjambukuController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\NotifController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/gg', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// user
Route::group(['prefix' => '/'], function () {
    Route::get('/', [FrontController::class, 'index'])->name('frontend.index');

    Route::post('/contact', [KontakController::class, 'store'])->name('kontak.store');


    // Route::resource('kontak', KontakController::class);
    Route::get('buku/{id}', [BukuController::class, 'show']);


    // live chat
    // Route::post('/send-chat', function (Request $request) {
    //     $chat = Chat::create([
    //         'id_user' => auth()->id(),
    //         'message' => $request->input('message')
    //     ]);
    //     return response()->json($chat);
    // });

    // Route::post('/send-chat', [ChatController::class, 'store']);
    // Route::get('/', [ChatController::class, 'index']);

    Route::group(['middleware' => ['auth']], function () {
        // Route::resource('pinjambuku', PinjambukuController::class);
        Route::get('pinjam/buku/{id}', [FrontController::class, 'ShowPinjambuku']);

    });


});

// profil
Route::group(['prefix' => 'profil', 'middleware' => ['auth']], function () {
    Route::get('dashboard', [FrontController::class, 'perpustakaan']);
    Route::get('daftarbuku', [FrontController::class, 'daftarbuku']);
    Route::get('buku/{id}', [FrontController::class, 'showbukuprofil']);
    Route::get('pinjam/buku/{id}', [FrontController::class, 'pinjambukuprofil']);

    // Route untuk menampilkan profil pengguna
    Route::get('anda', [FrontController::class, 'profil'])->name('profil.show');

    // Route untuk memperbarui profil 
    Route::patch('anda/{id}', [UsersController::class, 'update'])->name('profil.update');

    Route::get('pinjambuku', [PinjambukuController::class, 'index'])->name('profil.peminjamanBuku');

    Route::post('pinjambuku', [PinjambukuController::class, 'store'])->name('pinjambuku.store');

    Route::put('pinjambuku/{id}/ajukan-pengembalian', [PinjamBukuController::class, 'ajukanpengembalian'])->name('pinjambuku.ajukanpengembalian');

    Route::post('batalkan-pengajuan-pengembalian/{id}', [PinjamBukuController::class, 'batalkanpengajuanpengembalian'])->name('batalkan.pengajuan.pengembalian');

    Route::post('batalkan-pengajuan/{id}', [PinjamBukuController::class, 'batalkanpengajuan'])->name('batalkan.pengajuan');

    // Route::get('/notifications', [NotifController::class, 'index'])->name('notifications.index');

    Route::get('riwayat', [FrontController::class, 'riwayat'])->name('profil.testimoni');

    Route::get('testimoni/{id}', [TestimoniController::class, 'create'])->name('testimoni.create');


    // Route untuk menyimpan testimoni ke database
    Route::post('testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');

    Route::post('/notification/{id}/mark-as-read', [NotificationController::class, 'index'])->name('notifications.markAsRead');




});

// admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', IsAdmin::class]], function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });
    Route::resource('kategori', App\Http\Controllers\KategoriController::class);
    Route::resource('penulis', App\Http\Controllers\PenulisController::class);
    Route::resource('penerbit', App\Http\Controllers\PenerbitController::class);
    Route::resource('buku', App\Http\Controllers\BukuController::class);
    Route::resource('dashboard', App\Http\Controllers\BackController::class);
    Route::resource('user', App\Http\Controllers\UsersController::class);

    Route::get('dipinjam', [App\Http\Controllers\BackController::class, 'dipinjam']);

    Route::get('pengembalian', [App\Http\Controllers\BackController::class, 'riwayat']);

    Route::get('pengajuankembali', [App\Http\Controllers\BackController::class, 'pengajuankembali'])->name('admin.dataPeminjaman.permintaanPengembalian');

    Route::post('pinjambuku/tolak/{id}', [PinjamBukuController::class, 'tolakpengembalian'])->name('pinjambuku.tolak');

    Route::get('pinjambuku', [App\Http\Controllers\BackController::class, 'permintaan'])->name('admin.dataPeminjaman.permintaanPeminjaman');

    Route::put('pinjambuku/menyetujui/{id}', [PinjambukuController::class, 'menyetujui'])->name('pinjambuku.menyetujui');

    Route::put('pinjambuku/tolak/{id}', [PinjambukuController::class, 'tolakpengajuan'])->name('pinjambuku.tolak');

    Route::put('pinjambuku/{id}/accpengembalian', [PinjambukuController::class, 'accpengembalian'])->name('admin.dataPeminjaman.accpengembalian');

    Route::get('ditolak', [App\Http\Controllers\BackController::class, 'tidakdisetujui']);

    Route::get('kontak', [App\Http\Controllers\BackController::class, 'kontak']);

    Route::post('import-kategori', [App\Http\Controllers\KategoriController::class, 'import'])->name('import.kategori');

    
});
