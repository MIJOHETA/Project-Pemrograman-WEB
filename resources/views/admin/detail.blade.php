@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-red-600 mb-6 transition">
        &larr; Kembali ke Dashboard
    </a>

    <div class="grid lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="glass-card p-8 rounded-3xl">
                <div class="flex justify-between items-start mb-6">
                    <span class="bg-red-50 text-red-700 px-3 py-1 rounded-full text-xs font-bold tracking-wide uppercase border border-red-100">
                        {{ $laporan->jenis_laporan }}
                    </span>
                    <span class="text-sm text-gray-500">{{ $laporan->created_at->translatedFormat('l, d F Y H:i') }}</span>
                </div>

                <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $laporan->judul }}</h1>
                
                <div class="prose text-gray-600 text-sm leading-relaxed mb-6">
                    {{ $laporan->deskripsi }}
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm bg-white/40 p-4 rounded-xl border border-white/50">
                    <div>
                        <span class="block text-xs text-gray-400 uppercase">Pelapor</span>
                        <span class="font-medium text-gray-800">{{ $laporan->nama }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400 uppercase">Kontak</span>
                        <span class="font-medium text-gray-800">{{ $laporan->kontak ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400 uppercase">Lokasi</span>
                        <span class="font-medium text-gray-800">{{ $laporan->lokasi }}</span>
                    </div>
                    <div>
                        <span class="block text-xs text-gray-400 uppercase">Fakultas/Jurusan</span>
                        <span class="font-medium text-gray-800">{{ $laporan->jurusan->fakultas->name ?? '-' }} / {{ $laporan->jurusan->name ?? '-' }}</span>
                    </div>
                </div>
            </div>

            @if($laporan->foto)
            <div class="glass-card p-4 rounded-3xl">
                <h3 class="text-sm font-bold text-gray-700 mb-3">Bukti Foto</h3>
                <img src="{{ asset('storage/' . $laporan->foto) }}" alt="Bukti Laporan" class="rounded-xl w-full object-cover max-h-[400px]">
            </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="glass-card p-6 rounded-3xl border-t-4 border-red-500">
                <h3 class="font-bold text-gray-800 mb-4">Tindak Lanjut</h3>
                
                <form action="{{ route('admin.report.update', $laporan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Update Status</label>
                        <select name="status" class="w-full px-4 py-2 rounded-xl bg-white border border-gray-200 focus:ring-red-500 outline-none">
                            <option value="Baru" {{ $laporan->status == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Diproses" {{ $laporan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ $laporan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Catatan Admin (Balasan)</label>
                        <textarea name="admin_note" rows="4" class="w-full px-4 py-2 rounded-xl bg-white border border-gray-200 focus:ring-red-500 outline-none text-sm" placeholder="Tulis pesan untuk pelapor...">{{ $laporan->note }}</textarea>
                        <p class="text-[10px] text-gray-400 mt-1">*Pesan ini akan dikirim ke WhatsApp pelapor jika tersedia.</p>
                    </div>

                    <button type="submit" class="w-full bg-gray-900 text-white font-bold py-3 rounded-xl hover:bg-black transition">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <div class="glass-card p-6 rounded-3xl">
                <form action="{{ route('admin.report.destroy', $laporan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini permanen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-red-600 text-sm font-medium py-2 hover:bg-red-50 rounded-lg transition">
                        Hapus Laporan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection