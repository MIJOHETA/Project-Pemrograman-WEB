<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Fakultas;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    public function create() {
        $fakultas = Fakultas::all();
        return view('laporan.create', compact('fakultas'));
    }

    public function getJurusan(Request $request) {
        $jurusan = Jurusan::where('fakultas_id', $request->fakultas_id)->get();
        return response()->json($jurusan);
    }

    public function store(Request $request) {
        $request->validate([
            'jenis_laporan' => 'required|in:Laporan,Aspirasi',
            'jurusan_id'    => 'required',
            'judul'         => 'required|max:255',
            'deskripsi'     => 'required',
            'foto'          => 'nullable|image|max:5120', 
            'kategori'      => 'required_if:jenis_laporan,Laporan',
            'lokasi'        => 'required_if:jenis_laporan,Laporan',
        ]);

        $pathFoto = null;
        if ($request->hasFile('foto')) {
            $pathFoto = $request->file('foto')->store('laporan_images', 'public');
        }

        $laporan = Laporan::create([
            'jenis_laporan' => $request->jenis_laporan,
            'jurusan_id'    => $request->jurusan_id,
            'nama'          => $request->nama ?? 'Anonim',
            'kontak'        => $request->kontak,
            'judul'         => $request->judul,
            'deskripsi'     => $request->deskripsi,
            'kategori'      => $request->kategori,
            'lokasi'        => $request->lokasi,
            'foto'          => $pathFoto,
            'status'        => 'Baru' 
        ]);

        $this->sendWhatsapp($laporan);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    private function sendWhatsapp($report) {
        $adminPhone = '08.......'; // masukkan nomor admin tujuan 
        
        $message = "*LAPORAN BARU MASUK*\n";
        $message .= "Judul: " . $report->judul . "\n";
        $message .= "Jenis: " . $report->jenis_laporan . "\n";
        $message .= "Isi: " . Str::limit($report->deskripsi, 100) . "\n";
        
        if ($report->foto) {
            $message .= "Link Foto: " . asset('storage/' . $report->foto) . "\n";
        }
        
        try {
            Http::withHeaders([
                'Authorization' => 'gPiwBWar4Qyzo6EZ2eNu', 
            ])->post('https://api.fonnte.com/send', [
                'target' => $adminPhone,
                'message' => $message,
            ]);
        } catch (\Exception $e) {}
    }
}