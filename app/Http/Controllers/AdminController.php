<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Http;     // Digunakan untuk melakukan request API ke Fonnte (WhatsApp)
use Illuminate\Support\Facades\Storage;  // Digunakan untuk mengelola file (menghapus foto)

class AdminController extends Controller
{
    /**
     * Menampilkan Dashboard Admin (Daftar semua laporan)
     */
    public function index() {
        // Mengambil semua data laporan dari database
        // with('jurusan'): Teknik Eager Loading agar query database lebih ringan (mengambil nama jurusan sekaligus)
        // latest(): Mengurutkan data dari yang paling baru masuk
        $laporans = Laporan::with('jurusan')->latest()->get();
        
        // Mengirim data $laporans ke view 'admin.index'
        return view('admin.index', compact('laporans'));
    }

    /**
     * Menampilkan Detail Laporan Spesifik
     */
    public function show($id) {
        // Mencari laporan berdasarkan ID. Jika tidak ketemu, otomatis return error 404 (findOrFail)
        $laporan = Laporan::with('jurusan')->findOrFail($id);
        
        // Mengirim data laporan ke view 'admin.detail'
        return view('admin.detail', compact('laporan'));
    }

    /**
     * Mengupdate Status Laporan & Menyimpan Catatan Admin
     */
    public function update(Request $request, $id) {
        // 1. Cari data laporan yang mau diedit
        $laporan = Laporan::findOrFail($id);

        // 2. Validasi input dari form
        // Status wajib diisi dan hanya boleh berisi: 'Baru', 'Diproses', atau 'Selesai'
        $request->validate([
            'status' => 'required|in:Baru,Diproses,Selesai',
            'admin_note' => 'nullable|string' // Catatan boleh kosong
        ]);

        // 3. Update status laporan di database
        $laporan->status = $request->status;

        // 4. Jika admin mengisi catatan, simpan ke kolom 'note'
        // 'filled' mengecek apakah input tidak kosong
        if ($request->filled('admin_note')) {
            $laporan->note = $request->admin_note;
        }

        // 5. Simpan perubahan ke database
        $laporan->save();

        // 6. Cek apakah pelapor mencantumkan nomor kontak
        // Jika ada kontak, jalankan fungsi notifyUser untuk kirim WA
        if ($laporan->kontak) {
            $this->notifyUser($laporan, $request->admin_note);
        }

        // 7. Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Status diperbarui & Notifikasi dikirim.');
    }

    /**
     * Menghapus Laporan (Database & File Foto)
     */
    public function destroy($id) {
        $laporan = Laporan::findOrFail($id);
        
        // Cek apakah laporan ini memiliki lampiran foto
        if ($laporan->foto) {
            // Hapus file fisik foto dari folder 'storage/public' agar server tidak penuh
            Storage::disk('public')->delete($laporan->foto);
        }
        
        // Hapus data dari database
        $laporan->delete();
        
        // Kembali ke dashboard utama
        return redirect()->route('admin.dashboard')->with('success', 'Laporan berhasil dihapus.');
    }

    /**
     * Fungsi Private (Helper) untuk mengirim notifikasi WhatsApp
     * Tidak bisa diakses lewat URL browser, hanya dipanggil oleh fungsi lain di class ini
     */
    private function notifyUser($laporan, $pesanAdmin) {
        // 1. Menyusun template pesan WhatsApp
        $message = "*UPDATE STATUS LAPORAN*\n"; // Tanda * untuk menebalkan teks di WA
        $message .= "Halo " . ($laporan->nama ?? 'Sobat Kampus') . ",\n"; // Pakai 'Sobat Kampus' jika nama anonim/null
        $message .= "Laporan: *" . $laporan->judul . "*\n";
        $message .= "Status Sekarang: *" . strtoupper($laporan->status) . "*\n\n";
        
        // Jika ada pesan admin, tambahkan ke template
        if ($pesanAdmin) {
            $message .= "*Pesan Admin:*\n\"" . $pesanAdmin . "\"\n";
        }

        // 2. Mengirim Request ke API Fonnte
        // Menggunakan try-catch agar jika Fonnte error/down, website tidak ikut error (crash)
        try {
            Http::withHeaders([
                'Authorization' => 'gPiwBWar4Qyzo6EZ2eNu', // Token API Fonnte Anda
            ])->post('https://api.fonnte.com/send', [
                'target' => $laporan->kontak, // Nomor tujuan
                'message' => $message,        // Isi pesan
            ]);
        } catch (\Exception $e) {
            // Jika gagal kirim, error ditangkap di sini (bisa ditambahkan Log::error jika perlu)
        }
    }
}