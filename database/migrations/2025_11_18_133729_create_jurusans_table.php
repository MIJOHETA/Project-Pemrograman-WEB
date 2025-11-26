<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Dijalankan saat 'php artisan migrate'
     */
    public function up(): void
    {
        Schema::create('jurusans', function (Blueprint $table) {
            // 1. Primary Key
            // ID unik untuk setiap jurusan (misal: 1 = TI, 2 = Sipil)
            $table->id();

            // 2. Foreign Key (KUNCI RELASI) - Bagian Paling Penting!
            // a. foreignId('fakultas_id'): Membuat kolom untuk menyimpan ID Fakultas pemilik jurusan ini.
            // b. constrained('fakultas'): Menjaga data agar valid. Kita tidak bisa memasukkan ID Fakultas yang tidak ada di tabel 'fakultas'.
            // c. onDelete('cascade'): Efek Domino.
            //    Jika Admin menghapus "Fakultas Teknik", maka Jurusan "TI", "Sipil", "Mesin" otomatis terhapus.
            //    Ini mencegah error di aplikasi karena ada jurusan tanpa fakultas.
            $table->foreignId('fakultas_id')->constrained('fakultas')->onDelete('cascade');

            // 3. Nama Jurusan
            $table->string('name');

            // 4. Timestamps
            // Mencatat kapan jurusan ini dibuat dan diupdate.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * Dijalankan saat rollback.
     */
    public function down(): void
    {
        // Menghapus tabel jurusans
        Schema::dropIfExists('jurusans');
    }
};