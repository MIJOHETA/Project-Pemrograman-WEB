<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporanController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Halaman Publik ---

// 1. Halaman Utama (Formulir Laporan & Aspirasi)
Route::get('/', [LaporanController::class, 'create'])->name('home');

// 2. Proses Simpan Laporan
Route::post('/store', [LaporanController::class, 'store'])->name('report.store');

// 3. AJAX: Mengambil Data Jurusan berdasarkan Fakultas
Route::get('/get-jurusan', [LaporanController::class, 'getJurusan'])->name('get.jurusan'); 


// --- Autentikasi Admin ---

// 4. Halaman Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// 5. Proses Login
Route::post('/login', [AuthController::class, 'login']);

// 6. Proses Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- Halaman Admin (Butuh Login) ---
Route::middleware(['auth'])->prefix('admin')->group(function () {
    
    // 7. Dashboard Admin (Daftar Laporan)
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // 8. Detail Laporan
    Route::get('/report/{id}', [AdminController::class, 'show'])->name('admin.report.show');
    
    // 9. Update Status & Catatan Laporan
    Route::put('/report/{id}', [AdminController::class, 'update'])->name('admin.report.update');
    
    // 10. Hapus Laporan
    Route::delete('/report/{id}', [AdminController::class, 'destroy'])->name('admin.report.destroy');
});