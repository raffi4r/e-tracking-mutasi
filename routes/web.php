<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MutasiController;

Route::get('/', function () {
    return view('tracking.tracking');
});

// ✅ Dashboard (halaman utama setelah login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])
    ->middleware('auth')
    ->name('profile.password.update');

// ✅ Group semua rute yang butuh login
Route::middleware(['auth'])->group(function () {

    // Profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 🔹 CRUD Mutasi
    Route::get('/mutasi', [MutasiController::class, 'index'])->name('mutasi.index');
    Route::get('/mutasi/data', [MutasiController::class, 'data'])->name('mutasi.data'); // DataTables AJAX
    Route::get('/mutasi/create', [MutasiController::class, 'create'])->name('mutasi.create');
    Route::post('/mutasi', [MutasiController::class, 'store'])->name('mutasi.store');
    Route::get('/mutasi/{id}', [MutasiController::class, 'show'])->name('mutasi.show');
    Route::get('/mutasi/{id}/edit', [MutasiController::class, 'edit'])->name('mutasi.edit');
    Route::put('/mutasi/{id}', [MutasiController::class, 'update'])->name('mutasi.update');
    Route::delete('/mutasi/{id}', [MutasiController::class, 'destroy'])->name('mutasi.destroy');

    // 🔹 Update status (AJAX)
    Route::put('/mutasi/{id}/status', [MutasiController::class, 'updateStatus'])->name('mutasi.updateStatus');
});

// ✅ Rute publik (tidak perlu login)
Route::get('/tracking', [MutasiController::class, 'tracking'])->name('mutasi.tracking');
Route::post('/tracking/result', [MutasiController::class, 'trackingResult'])->name('tracking.result');

require __DIR__ . '/auth.php';
