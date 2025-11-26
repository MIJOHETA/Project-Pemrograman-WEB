<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Facade inti Laravel untuk fitur otentikasi (Login/Logout)

class AuthController extends Controller
{
    /**
     * Menampilkan Halaman Form Login
     * Method: GET
     */
    public function showLoginForm()
    {
        // Mengembalikan file view 'resources/views/auth/login.blade.php'
        return view('auth.login');
    }

    /**
     * Memproses Data Login yang Dikirim User
     * Method: POST
     */
    public function login(Request $request)
    {
        // 1. VALIDASI INPUT
        // Memastikan email berformat benar dan password tidak kosong
        // Jika validasi gagal, Laravel otomatis mengembalikan user ke halaman login dengan error
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. PROSES OTENTIKASI (PENCEKAN DATABASE)
        // Auth::attempt akan melakukan:
        // a. Mencari user di tabel 'users' berdasarkan email.
        // b. Jika ketemu, password yang diinput akan di-HASH dan dicocokkan dengan password di database.
        // c. Jika cocok, user dianggap login.
        if (Auth::attempt($credentials)) {
            
            // 3. KEAMANAN SESSION (SESSION FIXATION PREVENTION)
            // Ini SANGAT PENTING. Mengganti ID session lama dengan yang baru saat login berhasil.
            // Tujuannya mencegah hacker membajak session (Session Fixation Attack).
            $request->session()->regenerate();
            
            // 4. REDIRECT CERDAS
            // 'intended' akan mengarahkan user ke halaman yang tadinya ingin mereka buka sebelum disuruh login.
            // Jika tidak ada, default-nya ke 'admin/dashboard'.
            return redirect()->intended('admin/dashboard');
        }

        // 5. JIKA LOGIN GAGAL
        // Kembalikan ke halaman login dengan pesan error pada kolom email.
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Memproses Logout
     * Method: POST
     */
    public function logout(Request $request)
    {
        // 1. Hapus status login user
        Auth::logout();

        // 2. INVALIDASI SESSION
        // Menghapus semua data session server agar tidak bisa dipakai ulang oleh orang lain.
        $request->session()->invalidate();

        // 3. REGENERATE CSRF TOKEN
        // Membuat token keamanan baru untuk form selanjutnya.
        // Mencegah serangan CSRF (Cross-Site Request Forgery) pada login berikutnya.
        $request->session()->regenerateToken();

        // 4. Kembalikan ke halaman utama (Landing Page)
        return redirect('/');
    }
}