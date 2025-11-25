@extends('layouts.app')

@section('content')
<div x-data="{ activeTab: 'home', fakultasId: '', jurusans: [] }" class="max-w-4xl mx-auto">
    
    <div class="text-center mb-10">
        <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4 tracking-tight">
            Suara Anda, <span class="text-red-600">Perubahan Kita.</span>
        </h2>
        <p class="text-gray-600 max-w-2xl mx-auto text-lg leading-relaxed">
            Sampaikan aspirasi dan laporan permasalahan fasilitas, akademik, maupun keamanan di lingkungan Universitas Hasanuddin secara transparan.
        </p>
    </div>

    <!-- Menampilkan Error Validasi -->
    @if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl shadow-sm">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex justify-center mb-8">
        <div class="glass p-1.5 rounded-full inline-flex space-x-1 shadow-sm">
            @foreach(['home' => 'Buat Laporan', 'about' => 'Tentang', 'howto' => 'Cara Kerja'] as $key => $label)
                <button 
                    @click="activeTab = '{{ $key }}'" 
                    :class="activeTab === '{{ $key }}' ? 'bg-white text-red-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                    class="px-6 py-2.5 rounded-full text-sm font-medium transition-all duration-300">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    <div class="relative min-h-[500px]">
        
        <div x-show="activeTab === 'home'" x-transition.opacity.duration.500ms>
            <div class="glass-card p-8 rounded-3xl" x-data="{ tipe: 'Laporan' }">
                <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Pilihan Jenis Laporan -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <label class="cursor-pointer">
                            <input type="radio" name="jenis_laporan" value="Laporan" x-model="tipe" class="peer sr-only" checked>
                            <div class="p-4 rounded-xl border border-gray-200 bg-white/50 hover:bg-white peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 transition text-center">
                                <span class="block font-bold">🚨 Laporan</span>
                                <span class="text-xs">Kerusakan, keamanan, dll.</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="jenis_laporan" value="Aspirasi" x-model="tipe" class="peer sr-only">
                            <div class="p-4 rounded-xl border border-gray-200 bg-white/50 hover:bg-white peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 transition text-center">
                                <span class="block font-bold">💡 Aspirasi</span>
                                <span class="text-xs">Ide & saran perbaikan.</span>
                            </div>
                        </label>
                    </div>


                    <!-- FORM LAPORAN -->
                    <div x-show="tipe === 'Laporan'" class="space-y-6">
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 ml-1">Nama (opsional)</label>
                            <input type="text" name="nama" :disabled="tipe !== 'Laporan'" placeholder="Kosongkan untuk anonim" class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-1 outline-none transition">
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 ml-1">Fakultas</label>
                                <select name="fakultas_id" :disabled="tipe !== 'Laporan'" x-model="fakultasId" 
                                    @change="fetch('{{ route('get.jurusan') }}?fakultas_id=' + fakultasId).then(r => r.json()).then(data => jurusans = data)"
                                    class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-1 outline-none transition">
                                    <option value="">Pilih Fakultas...</option>
                                    @foreach($fakultas as $f)
                                        <option value="{{ $f->id }}">{{ $f->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 ml-1">Jurusan/Prodi</label>
                                <select name="jurusan_id" :disabled="tipe !== 'Laporan' || !fakultasId" class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-1 outline-none transition disabled:opacity-50">
                                    <option value="">Pilih Jurusan...</option>
                                    <template x-for="jurusan in jurusans" :key="jurusan.id">
                                        <option :value="jurusan.id" x-text="jurusan.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 ml-1">Judul Laporan</label>
                            <input type="text" name="judul" :disabled="tipe !== 'Laporan'" placeholder="Contoh: AC Rusak di Ruang 202" class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-1 outline-none transition">
                        </div>

                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 ml-1">Deskripsi Detail</label>
                            <textarea name="deskripsi" :disabled="tipe !== 'Laporan'" rows="4" placeholder="Jelaskan kronologi, lokasi spesifik, dan detail lainnya..." class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-1 outline-none transition"></textarea>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 ml-1">Kategori</label>
                                <select name="kategori" :disabled="tipe !== 'Laporan'" class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 outline-none transition">
                                    <option value="Fasilitas">Fasilitas</option>
                                    <option value="Keamanan">Keamanan</option>
                                    <option value="Akademik">Akademik</option>
                                    <option value="Kebersihan">Kebersihan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 ml-1">Lokasi Spesifik</label>
                                <input type="text" name="lokasi" :disabled="tipe !== 'Laporan'" placeholder="Gedung B, Lantai 2" class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 outline-none transition">
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 ml-1">Nomor WhatsApp (Opsional)</label>
                                <input type="text" name="kontak" :disabled="tipe !== 'Laporan'" placeholder="08..." class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 outline-none transition">
                                <p class="text-[10px] text-gray-500 ml-1">Untuk notifikasi status laporan.</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 ml-1">Foto Pendukung</label>
                                <input type="file" name="foto" :disabled="tipe !== 'Laporan'" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition"/>
                            </div>
                        </div>
                    </div>



                    <!-- FORM ASPIRASI -->
                    <div x-show="tipe === 'Aspirasi'" class="space-y-6">
                        
                        <!-- Nama -->
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 ml-1">Nama (opsional)</label>
                            <input type="text" name="nama" :disabled="tipe !== 'Aspirasi'" placeholder="Kosongkan untuk anonim" class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-1 outline-none transition">
                        </div>

                        <!-- Fakultas & Jurusan -->
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 ml-1">Fakultas</label>
                                <select name="fakultas_id" :disabled="tipe !== 'Aspirasi'" x-model="fakultasId" 
                                    @change="fetch('{{ route('get.jurusan') }}?fakultas_id=' + fakultasId).then(r => r.json()).then(data => jurusans = data)"
                                    class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-1 outline-none transition">
                                    <option value="">Pilih Fakultas...</option>
                                    @foreach($fakultas as $f)
                                        <option value="{{ $f->id }}">{{ $f->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label class="text-sm font-medium text-gray-700 ml-1">Jurusan/Prodi</label>
                                <select name="jurusan_id" :disabled="tipe !== 'Aspirasi' || !fakultasId" class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-1 outline-none transition disabled:opacity-50">
                                    <option value="">Pilih Jurusan...</option>
                                    <template x-for="jurusan in jurusans" :key="jurusan.id">
                                        <option :value="jurusan.id" x-text="jurusan.name"></option>
                                    </template>
                                </select>
                            </div>
                        </div>

                        <!-- Judul Aspirasi (name="judul" agar terbaca controller) -->
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 ml-1">Judul Aspirasi</label>
                            <input type="text" name="judul" :disabled="tipe !== 'Aspirasi'" placeholder="Contoh: Usulan Perbaikan Fasilitas" class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-1 outline-none transition">
                        </div>

                        <!-- Isi Aspirasi (name="deskripsi") -->
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 ml-1">Isi Aspirasi</label>
                            <textarea name="deskripsi" :disabled="tipe !== 'Aspirasi'" rows="4" placeholder="Tuliskan aspirasi, kritik, atau saran Anda dengan jelas..." class="w-full px-4 py-3 rounded-xl bg-white/50 border border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-1 outline-none transition"></textarea>
                        </div>

                        <!-- Upload Foto (name="foto") -->
                        <div class="space-y-1">
                            <label class="text-sm font-medium text-gray-700 ml-1">Upload Foto Pendukung (Opsional)</label>
                            <input type="file" name="foto" :disabled="tipe !== 'Aspirasi'" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition"/>
                        </div>

                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-red-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-red-600/30 hover:bg-red-700 hover:shadow-red-600/50 transition-all transform hover:-translate-y-0.5 active:translate-y-0" x-text="tipe === 'Laporan' ? 'Kirim Laporan' : 'Kirim Aspirasi'">
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bagian About dan Howto  -->
        <div x-show="activeTab === 'about'" x-transition.opacity.duration.500ms style="display: none;">
            <div class="glass-card p-8 rounded-3xl text-center space-y-6">
                <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto text-2xl">🏛️</div>
                <h3 class="text-2xl font-bold text-gray-800">Tentang Platform</h3>
                <p class="text-gray-600 leading-relaxed">
                    Lapor Unhas adalah inisiatif digitalisasi layanan pengaduan untuk menciptakan lingkungan kampus Universitas Hasanuddin yang lebih aman, nyaman, dan inklusif. Laporan Anda akan langsung diteruskan ke unit terkait untuk ditindaklanjuti.
                </p>
            </div>
        </div>

        <div x-show="activeTab === 'howto'" x-transition.opacity.duration.500ms style="display: none;">
            <div class="grid md:grid-cols-3 gap-6">
                @foreach([
                    ['step' => '1', 'title' => 'Tulis Laporan', 'desc' => 'Isi formulir dengan detail kejadian, lokasi, dan bukti foto.'],
                    ['step' => '2', 'title' => 'Verifikasi & Proses', 'desc' => 'Admin memverifikasi dan meneruskan ke unit teknis.'],
                    ['step' => '3', 'title' => 'Selesai', 'desc' => 'Masalah diselesaikan dan Anda mendapat notifikasi.'],
                ] as $item)
                <div class="glass-card p-6 rounded-2xl relative overflow-hidden group hover:border-red-200 transition">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-red-50 rounded-bl-full -mr-10 -mt-10 transition group-hover:bg-red-100"></div>
                    <span class="text-4xl font-bold text-red-600 mb-4 block">{{ $item['step'] }}</span>
                    <h4 class="font-bold text-gray-800 mb-2">{{ $item['title'] }}</h4>
                    <p class="text-sm text-gray-600">{{ $item['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection