<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AboutKamiController;
use App\Http\Controllers\AlurPendaftaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BookingUserController;
use App\Http\Controllers\TransaksiUserController;
use App\Http\Controllers\ReportController;



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

// Route melihat form booking (Bisa diakses publik)
Route::get('/booking/{id}', [BookingUserController::class, 'create'])->name('user.booking.create');
Route::get('/booking/identity/form', [BookingUserController::class, 'identityForm'])->name('user.booking.identity');
Route::post('/booking', [BookingUserController::class, 'store'])->name('user.booking.store');

Route::get('/cek-booking', function () {
    return view('pages.cek_booking');
})->name('guest.cek_booking');
Route::post('/cek-booking', function (\Illuminate\Http\Request $request) {
    $request->validate(['identifier' => 'required|string']);
    return redirect()->route('guest.transaksi.show', $request->identifier);
})->name('guest.cek_booking.process');

// Route Guest Transaksi
Route::get('/transaksi/guest/{identifier}', [TransaksiUserController::class, 'guestShow'])->name('guest.transaksi.show');
Route::post('/transaksi/guest/{kode_booking}/upload', [TransaksiUserController::class, 'guestUpload'])->name('guest.transaksi.upload');
Route::get('/transaksi/{id}/struk', [TransaksiUserController::class, 'cetakStruk'])->name('transaksi.struk');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    // Routes admin/pemilik dekost (Tampilan)
    Route::get('/pemilik_dekost/booking', [BookingController::class, 'index'])->name('pemilik_dekost.booking.index');
    Route::get('/pemilik_dekost/transaksi', [TransaksiController::class, 'index'])->name('pemilik_dekost.transaksi.index');
    
    // Route Auth User Transaksi
    Route::get('/transaksi', [TransaksiUserController::class, 'index'])->name('user.transaksi.index');
    Route::post('/transaksi/{id}/upload', [TransaksiUserController::class, 'uploadBukti'])->name('user.transaksi.upload');

    // Route Admin Verification
    Route::delete('/pemilik_dekost/booking/{id}', [BookingController::class, 'destroy'])->name('pemilik_dekost.booking.destroy');
    Route::post('/pemilik_dekost/booking/{id}/selesai', [BookingController::class, 'selesai'])->name('pemilik_dekost.booking.selesai');
    
    Route::post('/pemilik_dekost/transaksi/{id}/verify/{action}', [TransaksiController::class, 'verifyPayment'])->name('pemilik_dekost.transaksi.verify');
    Route::get('/pemilik_dekost/transaksi/create', [TransaksiController::class, 'create'])->name('pemilik_dekost.transaksi.create');
    Route::post('/pemilik_dekost/transaksi/store', [TransaksiController::class, 'storeManual'])->name('pemilik_dekost.transaksi.store');

    // Admin Reports
    Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/admin/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('admin.reports.export.pdf');
    Route::get('/admin/reports/export/excel', [ReportController::class, 'exportExcel'])->name('admin.reports.export.excel');

    // Owner Reports
    Route::get('/pemilik_dekost/reports', [ReportController::class, 'ownerIndex'])->name('pemilik_dekost.reports.index');
    Route::get('/pemilik_dekost/reports/export/pdf', [ReportController::class, 'ownerExportPdf'])->name('pemilik_dekost.reports.export.pdf');
    Route::get('/pemilik_dekost/reports/export/excel', [ReportController::class, 'ownerExportExcel'])->name('pemilik_dekost.reports.export.excel');
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
Route::post('/alur_pendaftaran/update-all', [AlurPendaftaranController::class, 'updateAll'])->name('alur_pendaftaran.update_all');

//barcode
Route::get('/kost/{id}/report', [KostController::class, 'showReport'])->name('kost.report');
Route::get('/kost/{id}/barcode', [KostController::class, 'printBarcode'])->name('barcode.kost');
