@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Dashboard Laporan</h2>
            <p class="text-gray-500 mt-1">Kelola semua laporan masuk dari civitas akademika.</p>
        </div>
        <div class="flex gap-2">
            <div class="glass px-4 py-2 rounded-lg text-sm">
                Total: <span class="font-bold text-red-600">{{ $laporans->count() }}</span>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-red-50 text-red-900 uppercase text-xs font-bold">
                    <tr>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Pelapor</th>
                        <th class="px-6 py-4">Judul / Lokasi</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($laporans as $laporan)
                    <tr class="hover:bg-white/50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $laporan->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $laporan->nama }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-800">{{ $laporan->judul }}</div>
                            <div class="text-xs text-gray-500">{{ $laporan->lokasi }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs border border-gray-200">
                                {{ $laporan->kategori ?? $laporan->jenis_laporan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $statusColor = match($laporan->status) {
                                    'Baru' => 'bg-red-100 text-red-700 border-red-200',
                                    'Diproses' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                    'Selesai' => 'bg-green-100 text-green-700 border-green-200',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <span class="px-3 py-1 rounded-full text-xs border font-medium {{ $statusColor }}">
                                {{ $laporan->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.report.show', $laporan->id) }}" class="text-red-600 hover:text-red-800 font-medium hover:underline">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">Belum ada laporan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection