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
            $table->id();
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade');
            $table->string('jenis_laporan'); 
            $table->string('nama')->nullable(); 
            $table->string('kontak')->nullable(); 
            $table->string('judul'); 
            $table->text('deskripsi');
            $table->string('lokasi')->nullable();   
            $table->string('foto')->nullable();
            $table->enum('status', ['Baru', 'Diproses', 'Selesai'])->default('Baru');
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};