<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jurusan extends Model
{
    use HasFactory;
    
    // GUARDED: Keamanan Database
    // Kita melindungi kolom 'id' agar tidak bisa diubah sembarangan oleh user.
    // Kolom lain (seperti 'name', 'fakultas_id') boleh diisi massal (Mass Assignment).
    protected $guarded = ['id'];

    /**
     * RELASI: Belongs To (Milik...)
     * Logika: "Satu Jurusan PASTI milik satu Fakultas".
     * Contoh: Jurusan Sipil milik Fakultas Teknik. Tidak mungkin Sipil milik 2 fakultas sekaligus.
     * * Fungsi ini memungkinkan kita memanggil: $jurusan->fakultas->name
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }
}