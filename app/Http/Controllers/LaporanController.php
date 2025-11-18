<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Fakultas;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Http;


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
            'name' => 'required',
            'jurusan_id' => 'required',
            'description' => 'required',
            'kontak' => 'required',
        ]);

        $laporan = new Laporan;
        $laporan->jurusan_id = $request->jurusan_id;
        $laporan->name = $request->name;          
        $laporan->type = $request->type;          
        $laporan->kontak = $request->kontak;       
        
        $laporan->save();
        $this->sendWhatsapp($laporan);
        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }

    private function sendWhatsapp($report) {
        $adminPhone = '0882019547830';  
        
        $message = "Halo Admin, Laporan Baru Masuk!\n\n";
        $message .= "Pelapor: " . $report->name . "\n";
        $message .= "Tipe: " . $report->type . "\n";
        $message .= "Segera cek dashboard.";

        try {
            Http::withHeaders([
                'Authorization' => '', 
            ])->post('https://api.fonnte.com/send', [
                'target' => $adminPhone,
                'message' => $message,
            ]);
        } catch (\Exception $e) {
            \Log::error("Gagal kirim WA: " . $e->getMessage());
        }
    }
}