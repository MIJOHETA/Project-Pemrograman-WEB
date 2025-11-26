<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Method ini dijalankan saat Anda mengetik: 'php artisan migrate'
     */
    public function up(): void
    {
        // Perintah: Buat tabel baru bernama 'fakultas'
        Schema::create('fakultas', function (Blueprint $table) {
            
            // 1. Primary Key
            // Membuat kolom 'id' (Big Integer, Auto Increment, Primary Key).
            // Ini adalah nomor unik untuk setiap fakultas (1, 2, 3, dst).
            $table->id();

            // 2. Kolom Nama Fakultas
            // Membuat kolom 'name' bertipe VARCHAR (String).
            // Contoh isi: "Fakultas Teknik", "Fakultas MIPA".
            $table->string('name');

            // 3. Kolom Waktu Otomatis
            // Membuat 2 kolom sekaligus: 'created_at' dan 'updated_at'.
            // Laravel otomatis mengisi kapan data ini dibuat dan kapan terakhir diedit.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Method ini dijalankan saat Anda mengetik: 'php artisan migrate:rollback'
     * Tujuannya untuk membatalkan perubahan (Menghapus tabel).
     */
    public function down(): void
    {
        // Hapus tabel 'fakultas' jika tabelnya ada
        Schema::dropIfExists('fakultas');
    }
};