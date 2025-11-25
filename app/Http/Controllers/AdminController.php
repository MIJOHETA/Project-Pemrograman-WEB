<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index() {
        $laporans = Laporan::with('jurusan')->latest()->get();
        return view('admin.index', compact('laporans'));
    }

    public function show($id) {
        $laporan = Laporan::with('jurusan')->findOrFail($id);
        return view('admin.detail', compact('laporan'));
    }

    public function update(Request $request, $id) {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:Baru,Diproses,Selesai',
            'admin_note' => 'nullable|string'
        ]);

        $laporan->status = $request->status;

        if ($request->filled('admin_note')) {
            $laporan->note = $request->admin_note;
        }

        $laporan->save();

        if ($laporan->kontak) {
            $this->notifyUser($laporan, $request->admin_note);
        }

        return redirect()->back()->with('success', 'Status diperbarui & Notifikasi dikirim.');
    }

    public function destroy($id) {
        $laporan = Laporan::findOrFail($id);
        if ($laporan->foto) {
            Storage::disk('public')->delete($laporan->foto);
        }
        $laporan->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Laporan berhasil dihapus.');
    }

    private function notifyUser($laporan, $pesanAdmin) {
        $message = "*UPDATE STATUS LAPORAN*\n";
        $message .= "Halo " . ($laporan->nama ?? 'Sobat Kampus') . ",\n";
        $message .= "Laporan: *" . $laporan->judul . "*\n";
        $message .= "Status Sekarang: *" . strtoupper($laporan->status) . "*\n\n";
        
        if ($pesanAdmin) {
            $message .= "*Pesan Admin:*\n\"" . $pesanAdmin . "\"\n";
        }

        try {
            Http::withHeaders([
                'Authorization' => 'gPiwBWar4Qyzo6EZ2eNu', 
            ])->post('https://api.fonnte.com/send', [
                'target' => $laporan->kontak,
                'message' => $message,
            ]);
        } catch (\Exception $e) {}
    }
}