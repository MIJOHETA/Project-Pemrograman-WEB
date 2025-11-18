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
            $table->string('name');
            $table->string('type');
            $table->text('description');
            $table->string('kontak');
            $table->enum('status', ['Menunggu Konfirmasi', 'Dalam Proses', 'Selesai'])->default('Menunggu Konfirmasi');
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
