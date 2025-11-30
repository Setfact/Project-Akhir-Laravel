<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Halaman Publik
Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('/destinasi/{destination:slug}', [FrontController::class, 'show'])->name('destination.show');

// Halaman Perlu Login (Beli Tiket)
Route::middleware(['auth'])->group(function () {
    Route::post('/order/{destination}', [OrderController::class, 'store'])->name('order.store');
    Route::get('/tiket-saya', [OrderController::class, 'index'])->name('my.tickets');
});

// Tambahkan ini di routes/web.php agar error hilang
Route::get('/dashboard', function () {
    return redirect()->route('my.tickets');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';