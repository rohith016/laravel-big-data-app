<?php

use App\Http\Controllers\{
    SaleController,
    BulkEmailController,
    ProfileController
};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    Route::resource('/sales', SaleController::class);
    Route::get('/batch/{id}', [SaleController::class, 'batch'])->name('sales.batch');
    Route::resource('/emails', BulkEmailController::class);
});

require __DIR__.'/auth.php';
