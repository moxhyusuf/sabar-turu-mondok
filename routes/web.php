<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutKamiController;
use App\Http\Controllers\AlurPendaftaranController;
use App\Http\Controllers\DashboardController;



Route::get('/', [KostController::class, 'publicIndex'])->name('home');


Route::get('/about', [AboutKamiController::class, 'publicAbout'])->name('about');
Route::get('/alur', [AlurPendaftaranController::class, 'publicAlur'])->name('alur');
Route::get('/pemondokan', [KostController::class, 'userKost'])->name('user.kost');
Route::get('/pemondokan/{id}', [KostController::class, 'detail'])->name('kost.detail');






Route::get('/kontak', function () {
    return view('pages.kontak');
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



//milik tampilan admin

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});



// Route untuk user

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::post('/users/{id}/approve', [UserController::class, 'approve'])->name('users.approve');
Route::post('/users/{id}/reject', [UserController::class, 'reject'])->name('users.reject');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


// Route untuk kost
Route::get('/kost', [KostController::class, 'index'])->name('kost.index');
Route::get('/kost/{id}/edit', [KostController::class, 'edit'])->name('kost.edit');
Route::put('/kost/{id}', [KostController::class, 'update'])->name('kost.update');
Route::get('/kost/cari', [KostController::class, 'search'])->name('kost.search');
Route::get('/kost/cetak/laporan', [KostController::class, 'cetakLaporan'])
    ->name('kost.cetaklaporan');
Route::get('/kost/tambah', [KostController::class, 'create'])->name('kost.create');
Route::post('/kost', [KostController::class, 'store'])->name('kost.store');
Route::delete('/kost/{id}', [KostController::class, 'destroy'])->name('kost.destroy');

// Admin: lihat detail kost
Route::get('/kost/{id}', [App\Http\Controllers\KostController::class, 'showKost'])->name('kost.show');


Route::get('/pemondokkan/{id}', [KostController::class, 'detail'])->name('detailkost');


// Route untuk tentang kami
Route::get('/tentang_kami', [AboutKamiController::class, 'index'])->name('tentang_kami.index');
Route::get('/tentang_kami/{id}/edit', [AboutKamiController::class, 'edit'])->name('tentang_kami.edit');
Route::put('/tentang_kami/{id}', [AboutKamiController::class, 'update'])->name('tentang_kami.update');


// Route untuk alur pendaftaran
Route::get('/alur_pendaftaran', [AlurPendaftaranController::class, 'index'])->name('alur_pendaftaran.index');
Route::get('/alur_pendaftaran/{id}/edit', [AlurPendaftaranController::class, 'edit'])->name('alur_pendaftaran.edit');
Route::put('/alur_pendaftaran/{id}', [AlurPendaftaranController::class, 'update'])->name('alur_pendaftaran.update');

//barcode
Route::get('/kost/{id}/barcode', [KostController::class, 'printBarcode'])->name('barcode.kost');
