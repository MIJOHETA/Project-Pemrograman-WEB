<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Fakultas;
use App\Models\Jurusan;
// Library HTTP Client: Untuk "menembak" API Fonnte (Kirim WA)
use Illuminate\Support\Facades\Http;
// Library Storage: Untuk menyimpan file foto ke folder server
use Illuminate\Support\Facades\Storage; 
// Library Str: Untuk memotong teks (limit karakter)
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    /**
     * Menampilkan Halaman Form Laporan
     */
    public function create() {
        // Mengambil semua data fakultas untuk ditampilkan di dropdown pertama
        $fakultas = Fakultas::all();
        // compact('fakultas') mengirim variabel $fakultas ke view
        return view('laporan.create', compact('fakultas'));
    }

    /**
     * API untuk AJAX (Dynamic Dropdown)
     * Dipanggil oleh JavaScript saat user memilih Fakultas
     */
    public function getJurusan(Request $request) {
        // Query: Cari jurusan yang 'fakultas_id'-nya sesuai request
        $jurusan = Jurusan::where('fakultas_id', $request->fakultas_id)->get();
        
        // Mengembalikan data dalam format JSON agar mudah dibaca JavaScript
        return response()->json($jurusan);
    }

    /**
     * LOGIKA UTAMA: Menyimpan Data Laporan
     */
    public function store(Request $request) {
        // 1. VALIDASI INPUT (Security Layer 1)
        // Memastikan data yang masuk sesuai aturan sebelum diproses
        $request->validate([
            'jenis_laporan' => 'required|in:Laporan,Aspirasi', // Hanya boleh 2 nilai ini
            'jurusan_id'    => 'required',
            'judul'         => 'required|max:255',
            'deskripsi'     => 'required',
            // Validasi File: Harus gambar (jpg/png), maks ukuran 5MB (5120 KB)
            'foto'          => 'nullable|image|max:5120', 
            
            // VALIDASI BERSYARAT (Conditional Validation)
            // Kolom 'kategori' & 'lokasi' WAJIB diisi HANYA JIKA jenis_laporan adalah 'Laporan'.
            // Jika jenisnya 'Aspirasi', kolom ini boleh kosong.
            'kategori'      => 'required_if:jenis_laporan,Laporan',
            'lokasi'        => 'required_if:jenis_laporan,Laporan',
        ]);

        // 2. PROSES UPLOAD FOTO
        $pathFoto = null; // Default null jika user tidak upload foto
        
        // Cek apakah di form ada file yang diupload?
        if ($request->hasFile('foto')) {
            // Fungsi store():
            // a. Mengubah nama file secara acak (agar tidak bentrok).
            // b. Menyimpan file ke folder 'storage/app/public/laporan_images'.
            // c. Mengembalikan alamat path file tersebut ke variabel $pathFoto.
            $pathFoto = $request->file('foto')->store('laporan_images', 'public');
        }

        // 3. SIMPAN KE DATABASE (Eloquent ORM)
        // create() otomatis mencocokkan nama array dengan nama kolom di database
        $laporan = Laporan::create([
            'jenis_laporan' => $request->jenis_laporan,
            'jurusan_id'    => $request->jurusan_id,
            
            // Null Coalescing Operator (??)
            // Artinya: Jika $request->nama ada isinya, pakai itu. Jika kosong, pakai 'Anonim'.
            'nama'          => $request->nama ?? 'Anonim',
            
            'kontak'        => $request->kontak,
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'kategori'      => $request->kategori,
            'lokasi'        => $request->lokasi,
            'foto'          => $pathFoto, // Simpan path foto (string) ke database
            'status'        => 'Baru' // Set default status pelaporan baru
        ]);

        // 4. KIRIM NOTIFIKASI WA (Integrasi API)
        // Fungsi ini dijalankan di background (setelah data tersimpan)
        $this->sendWhatsapp($laporan);

        // 5. REDIRECT
        // Kembali ke halaman form dengan pesan sukses (disimpan di session flash)
        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    /**
     * Fungsi Private: Mengirim Pesan WhatsApp via Fonnte
     */
    private function sendWhatsapp($report) {
        $adminPhone = '08.......'; // Nomor Admin Penerima Laporan
        
        // Menyusun Pesan (String Concatenation)
        $message = "*LAPORAN BARU MASUK*\n"; // \n adalah Enter (Baris baru)
        $message .= "Judul: " . $report->judul . "\n";
        $message .= "Jenis: " . $report->jenis_laporan . "\n";
        
        // Str::limit memotong deskripsi panjang menjadi maks 100 huruf + "..."
        $message .= "Isi: " . Str::limit($report->deskripsi, 100) . "\n";
        
        // Jika ada foto, sertakan Link-nya
        if ($report->foto) {
            // asset() mengubah path 'storage/foto.jpg' menjadi URL lengkap 'http://website.com/storage/foto.jpg'
            // Ini penting agar Fonnte bisa mengakses gambar tersebut
            $message .= "Link Foto: " . asset('storage/' . $report->foto) . "\n";
        }
        
        // Blok Try-Catch (Error Handling)
        // Tujuannya: Jika server Fonnte sedang down atau internet mati,
        // Website kita TIDAK AKAN CRASH/ERROR. User tetap melihat pesan "Sukses",
        // meskipun notifikasi WA gagal terkirim.
        try {
            Http::withHeaders([
                'Authorization' => 'gPiwBWar4Qyzo6EZ2eNu', // Token API Anda
            ])->post('https://api.fonnte.com/send', [
                'target' => $adminPhone,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            // Error ditangkap diam-diam di sini
        }
    }
}