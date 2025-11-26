<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fakultas extends Model
{
    /**
     * HasFactory:
     * Mengaktifkan fitur Factory. Ini digunakan saat kita menjalankan 'DatabaseSeeder'.
     * Fitur ini yang memungkinkan kita membuat data dummy fakultas secara otomatis.
     */
    use HasFactory;

    /**
     * Mass Assignment Protection ($guarded):
     * Ini adalah fitur keamanan Laravel.
     * Artinya: "Lindungi kolom 'id', jangan biarkan diisi manual. Sisanya (seperti 'name') boleh diisi."
     * * Kenapa 'id' dilindungi? Karena 'id' adalah Auto Increment dari database, 
     * kita tidak boleh mengotak-atiknya secara manual lewat kode.
     */
    protected $guarded = ['id'];

    /**
     * Definisi Relasi (One-to-Many):
     * Logika: "Satu Fakultas memiliki BANYAK Jurusan".
     * * Contoh: Fakultas Teknik (1) memiliki jurusan:
     * - Teknik Informatika
     * - Teknik Sipil
     * - Teknik Mesin
     * * Karena hasilnya bisa BANYAK, maka kita menggunakan 'hasMany' 
     * dan nama fungsinya jamak/plural ('jurusans').
     */
    public function jurusans()
    {
        return $this->hasMany(Jurusan::class);
    }
}