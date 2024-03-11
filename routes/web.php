<?php

use App\Http\Middleware\UserAccess;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
Route::get('/home', function () {
    return redirect('/dashboardadmin');
});

Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth'])->group(function () {
    Route::get('logout', [AuthController::class, 'logout']);

    Route::middleware([UserAccess::class . ':Admin'])->group(function () {
        // ROUTE Admin Access only
        Route::get('/dashboardadmin', [DashboardController::class, 'dashboardAdmin'])->name('dashboardAdmin');

        Route::resource('useradm', UserController::class);
        Route::resource('mobil', MobilController::class);
        Route::resource('peminjaman', PeminjamanController::class);
        Route::resource('pengembalian', PengembalianController::class);
        // laporan peminjaman
        Route::get('/laporanpeminjaman', [PeminjamanController::class, 'laporan'])->name('laporanpeminjaman');
        Route::post('/cetak_laporanpeminjaman', [PeminjamanController::class, 'cetakLaporan'])->name('cetak_laporanpeminjaman');
        // laporan pengembalian
        Route::get('/laporanpengembalian', [PengembalianController::class, 'laporan'])->name('laporanpengembalian');
        Route::post('/cetak_laporanpengembalian', [PengembalianController::class, 'cetakLaporan'])->name('cetak_laporanpengembalian');
    });

    // ROUTE User / Login Access Only
    Route::get('/dashboarduser', [DashboardController::class, 'dashboardUser'])->name('dashboardUser');
    Route::get('/mobiluser', [DashboardController::class, 'mobilUser'])->name('mobilUser');
    Route::get('/mobil/detail/{id}', [DashboardController::class, 'mobilDetail'])->name('mobil.detail');
    Route::get('/account', [DashboardController::class, 'account'])->name('account');

    // Peminjaman User
    Route::get('/rental/form/{mobil_id}', [PeminjamanController::class, 'formPeminjaman'])->name('rental.form');
    Route::post('/rental/create', [PeminjamanController::class, 'createPeminjaman'])->name('rental.create');
    Route::get('/rentalan', [PeminjamanController::class, 'rentalan'])->name('rentalan');
    Route::post('/kembalikan/{rental}', [PeminjamanController::class, 'kembalikan'])->name('kembalikan');

    // Route fitur search
    Route::get('/mobils/search', [MobilController::class, 'searchByName'])->name('mobils.searchname');
    Route::get('/searchmobil', [MobilController::class, 'searchByDate'])->name('mobils.searchdate');
    // Route::get('/useradm/search', [UserController::class, 'search'])->name('useradm.search');

    // Route::get('/peminjaman', [DashboardController::class, 'mobilUser'])->name('mobilUser'); showPeminjaman
});
// Route Register
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'saveRegister'])->name('saveRegister');
