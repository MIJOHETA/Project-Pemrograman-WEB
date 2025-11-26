<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            // 1. Primary Key (ID Unik Laporan)
            $table->id();

            // 2. Relasi ke Tabel Jurusan (Foreign Key)
            // - constrained('jurusans'): Data harus nyambung ke ID yang ada di tabel jurusans.
            // - onDelete('cascade'): Jika Admin menghapus sebuah Jurusan, maka semua laporan
            //   yang terkait dengan jurusan tersebut akan ikut terhapus otomatis.
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade');

            // 3. Pembeda Jenis (Penting untuk Logika Frontend/Backend)
            // Isinya nanti string: "Laporan" atau "Aspirasi"
            $table->string('jenis_laporan'); 

            // 4. Data Pelapor (Boleh Kosong / Nullable)
            // Dibuat nullable agar user bisa melapor secara 'Anonim' (tanpa nama).
            $table->string('nama')->nullable(); 
            $table->string('kontak')->nullable(); // No WA pelapor (opsional)

            // 5. Data Utama Laporan
            $table->string('judul'); 
            $table->text('deskripsi'); // Pakai 'text' agar muat paragraf panjang

            // 6. Lokasi (Nullable)
            // Kenapa Nullable? Karena jika user memilih "Aspirasi" (Ide),
            // biasanya tidak butuh lokasi spesifik. Kolom ini wajib diisi hanya jika "Laporan".
            $table->string('lokasi')->nullable();   

            // 7. Foto Bukti (Nullable)
            // Menyimpan "path" atau alamat file gambar (misal: "laporan_images/foto1.jpg").
            // Nullable karena user tidak wajib upload foto.
            $table->string('foto')->nullable();

            // 8. Status Laporan (Enum)
            // Membatasi input agar hanya bisa: 'Baru', 'Diproses', atau 'Selesai'.
            // default('Baru'): Saat pertama dibuat, status otomatis jadi 'Baru'.
            $table->enum('status', ['Baru', 'Diproses', 'Selesai'])->default('Baru');

            // 9. Catatan Admin
            // Tempat admin menulis balasan/tindak lanjut. Awalnya pasti kosong (null).
            $table->text('note')->nullable();

            // 10. Timestamp (Created_at & Updated_at)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};