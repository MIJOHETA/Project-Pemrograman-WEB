<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', [LaporanController::class, 'create'])->name('home');
Route::post('/store', [LaporanController::class, 'store'])->name('report.store');
Route::get('/get-jurusan', [LaporanController::class, 'getJurusan'])->name('get.jurusan'); 
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/report/{id}', [AdminController::class, 'show'])->name('admin.report.show');
    Route::put('/report/{id}', [AdminController::class, 'update'])->name('admin.report.update');
    Route::delete('/report/{id}', [AdminController::class, 'destroy'])->name('admin.report.destroy');
});

//require __DIR__.'/auth.php';