<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laporan extends Model
{
    /**
     * HasFactory:
     * Fitur standar Laravel untuk membuat data dummy (palsu) saat testing atau seeding.
     */
    use HasFactory;

    /**
     * Mass Assignment Protection ($guarded):
     * PERHATIAN: Di kode Anda tertulis '$guraded' (Typo).
     * Penulisan yang benar adalah '$guarded' (huruf 'u' sebelum 'a').
     * * Fungsinya: "Lindungi kolom 'id', jangan biarkan diisi manual. Sisanya boleh diisi massal."
     * Ini penting agar fungsi Laporan::create([...]) di controller bisa berjalan.
     */
    protected $guarded = ['id']; // <--- Pastikan tulisannya benar 'guarded'

    /**
     * Definisi Relasi (Inverse One-to-Many):
     * Logika: "Satu Laporan PASTI milik satu Jurusan".
     * * Fungsi ini menghubungkan kolom 'jurusan_id' di tabel laporans
     * dengan 'id' di tabel jurusans.
     * * Contoh penggunaan di Controller/View:
     * $laporan->jurusan->name; // Akan mencetak "Teknik Informatika"
     */
    public function jurusan()
    {
        // belongsTo = Milik dari...
        return $this->belongsTo(Jurusan::class);
    }
}