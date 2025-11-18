<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

class AdminController extends Controller
{
    public function index() {
        $laporans = Laporan::with('jurusan.fakultas')->latest()->get();
        return view('admin.index', compact('laporans'));
    }

    public function show($id) {
        $laporan = Laporan::with('jurusan.fakultas')->find($id);
        return view('admin.detail', compact('laporan'));
    }

    public function update(Request $request, $id) {
        $laporan = Laporan::find($id);
        $laporan->status = $request->status;
        
        if($request->has('note')){
            $laporan->note = $request->note;
        }

        $laporan->save();
        
        return redirect()->route('admin.dashboard')->with('success', 'Status diperbarui');
    }

    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id); 
        $laporan->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Laporan berhasil dihapus!');
    }
}