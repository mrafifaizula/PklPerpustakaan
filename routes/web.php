<?php


use App\Http\Controllers\BackController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PinjambukuController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenulisController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;
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


// Route::get('/ggg', function () {
//     return view(view: 'backend.kategori.importExcel');
// });


Auth::routes();

Route::get('/verify-otp', [OtpController::class, 'showOtpForm'])->name('otp.verify');
Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('post.otp.verify');
Route::get('/otp/resend', [OtpController::class, 'mintaUlangOtp'])->name('otp.mintaUlang');



Route::get('login/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('google/redirect', [GoogleController::class, 'handleGoogleCallback']);



// Guest
Route::group(['prefix' => '/'], function () {

    Route::get('/', [FrontController::class, 'index'])->name('frontend.index');
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('email', [BackController::class, 'show']);
    Route::post('/contact', [KontakController::class, 'store'])->name('kontak.store');
    Route::get('buku/{id}', [BukuController::class, 'show']);

    Route::group(['middleware' => ['auth']], function () {
        Route::get('pinjam/buku/{id}', [FrontController::class, 'ShowPinjambuku']);
    });
});


// Rute untuk profil pengguna
Route::group(['prefix' => 'profil', 'middleware' => ['auth', 'verified']], function () {
    Route::get('dashboard', [FrontController::class, 'perpustakaan'])->name('profil.dashboard');
    Route::get('daftarbuku', [FrontController::class, 'daftarbuku'])->name('daftarbuku');
    Route::get('buku/{id}', [FrontController::class, 'showbukuprofil']);
    Route::get('pinjam/buku/{id}', [FrontController::class, 'pinjambukuprofil']);

    // Profil pengguna
    Route::get('anda', [ProfilController::class, 'index'])->name('profil.show');
    Route::patch('anda/{id}', [ProfilController::class, 'update'])->name('profil.update');

    // Rute untuk peminjaman buku
    Route::get('pinjambuku', [PinjamBukuController::class, 'index'])->name('profil.peminjamanBuku');
    Route::post('pinjambuku', [PinjamBukuController::class, 'store'])->name('pinjambuku.store');
    Route::put('pinjambuku/{id}/ajukan-pengembalian', [PinjamBukuController::class, 'ajukanpengembalian'])->name('pinjambuku.ajukanpengembalian');
    Route::post('batalkan-pengajuan-pengembalian/{id}', [PinjamBukuController::class, 'batalkanpengajuanpengembalian'])->name('batalkan.pengajuan.pengembalian');
    Route::post('batalkan-pengajuan/{id}', [PinjamBukuController::class, 'batalkanpengajuan'])->name('batalkan.pengajuan');

    // Rute untuk riwayat dan testimoni
    Route::get('riwayat', [FrontController::class, 'riwayat'])->name('profil.testimoni');
    Route::get('testimoni/{id}', [TestimoniController::class, 'create'])->name('testimoni.create');
    Route::post('testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');

    // Notifikasi
    Route::post('/notification/{id}/mark-as-read', [NotificationController::class, 'index'])->name('notifications.markAsRead');
});



// Rute untuk admin dan staf
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin,staf']], function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    Route::get('dashboard', [BackController::class, 'index']);
    Route::resource('kategori', KategoriController::class);
    Route::resource('penulis', PenulisController::class);
    Route::resource('penerbit', PenerbitController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('user', UsersController::class);

    // Rute lainnya terkait peminjaman dan pengembalian buku
    Route::get('dipinjam', [BackController::class, 'dipinjam']);
    Route::get('pengembalian', [BackController::class, 'riwayat']);
    Route::get('pengajuankembali', [BackController::class, 'pengajuankembali'])->name('admin.dataPeminjaman.permintaanPengembalian');
    Route::get('pinjambuku', [BackController::class, 'permintaan'])->name('admin.dataPeminjaman.permintaanPeminjaman');

    Route::put('pinjambuku/menyetujui/{id}', [PinjamBukuController::class, 'menyetujui'])->name('pinjambuku.menyetujui');
    Route::put('pinjambuku/{id}', [PinjamBukuController::class, 'tolakpengajuan'])->name('pinjambuku.tolak');
    Route::put('pinjambuku/{id}/accpengembalian', [PinjamBukuController::class, 'accpengembalian'])->name('admin.dataPeminjaman.accpengembalian');
    Route::put('pinjambuku/tolak/{id}', [PinjamBukuController::class, 'tolakpengembalian'])->name('pengengembalian.tolak');

    Route::get('ditolak', [BackController::class, 'tidakdisetujui']);
    Route::get('kontak', [BackController::class, 'kontak']);


    // import excel
    Route::get('import/kategori', [KategoriController::class, 'import'])->name('import.kategori');
    Route::post('importManual/kategori', [KategoriController::class, 'importManual'])->name('importManual.kategori');
    Route::get('export-kategori', [KategoriController::class, 'exportManual'])->name('export.kategori');

    Route::get('import/penerbit', [PenerbitController::class, 'import'])->name('import.penerbit');
    Route::post('importManual/penerbit', [PenerbitController::class, 'importManual'])->name('importManual.penerbit');
    Route::get('export-penerbit', [PenerbitController::class, 'exportManual'])->name('export.penerbit');

    Route::get('import/penulis', [PenulisController::class, 'import'])->name('import.penulis');
    Route::post('importManual/penulis', [PenulisController::class, 'importManual'])->name('importManual.penulis');
    Route::get('export-penulis', [PenulisController::class, 'exportManual'])->name('export.penulis');

});

// // user hanya untuk admin
// Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:admin']], function () {
//     Route::resource('user', UsersController::class); // Hanya admin yang bisa mengakses resource user
// });

