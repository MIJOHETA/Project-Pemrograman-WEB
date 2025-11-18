<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Fakultas;
use App\Models\Jurusan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com', 
            'password' => Hash::make('admin123'), 
        ]);

        $feb = Fakultas::create(['name' => 'Fakultas Ekonomi dan Bisnis']);
        Jurusan::create(['fakultas_id' => $feb->id, 'name' => 'Ekonomi Pembangunan']);
        Jurusan::create(['fakultas_id' => $feb->id, 'name' => 'Manajemen']);
        Jurusan::create(['fakultas_id' => $feb->id, 'name' => 'Akuntansi']);
        Jurusan::create(['fakultas_id' => $feb->id, 'name' => 'Ekonomi Bisnis Islam']);
        Jurusan::create(['fakultas_id' => $feb->id, 'name' => 'Teknik Agroindustri']);

        $fh = Fakultas::create(['name' => 'Fakultas Hukum']);
        Jurusan::create(['fakultas_id' => $fh->id, 'name' => 'Hukum']);
        Jurusan::create(['fakultas_id' => $fh->id, 'name' => 'Hukum Administrasi Negara']);

        $fk = Fakultas::create(['name' => 'Fakultas Kedokteran']);
        Jurusan::create(['fakultas_id' => $fk->id, 'name' => 'Pendidikan Dokter']);
        Jurusan::create(['fakultas_id' => $fk->id, 'name' => 'Psikologi']);
        Jurusan::create(['fakultas_id' => $fk->id, 'name' => 'Kedokteran Gigi']);

        $ft = Fakultas::create(['name' => 'Fakultas Teknik']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Elektro']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Mesin']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Sipil']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Arsitektur']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Lingkungan']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Industri']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Pertambangan']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Geologi']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Perencanaan Wilayah Kota']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Perkapalan']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Sistem Perkapalan']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Kelautan']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Informatika']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Metalurgi dan Material']);
        Jurusan::create(['fakultas_id' => $ft->id, 'name' => 'Teknik Geodesi']);

        $fisip = Fakultas::create(['name' => 'Fakultas Ilmu Sosial dan Politik']);
        Jurusan::create(['fakultas_id' => $fisip->id, 'name' => 'Administrasi Publik']);
        Jurusan::create(['fakultas_id' => $fisip->id, 'name' => 'Hubungan Internasional']);
        Jurusan::create(['fakultas_id' => $fisip->id, 'name' => 'Ilmu Pemerintahan']);
        Jurusan::create(['fakultas_id' => $fisip->id, 'name' => 'Ilmu Politik']);
        Jurusan::create(['fakultas_id' => $fisip->id, 'name' => 'Sosiologi']);
        Jurusan::create(['fakultas_id' => $fisip->id, 'name' => 'Ilmu Komunikasi']);
        Jurusan::create(['fakultas_id' => $fisip->id, 'name' => 'Antropologi']);
        Jurusan::create(['fakultas_id' => $fisip->id, 'name' => 'Ilmu Administrasi']);
        Jurusan::create(['fakultas_id' => $fisip->id, 'name' => 'Ilmu Perpustakaan dan Sains Informasi']);

        $fib = Fakultas::create(['name' => 'Fakultas Ilmu Budaya']);
        Jurusan::create(['fakultas_id' => $fib->id, 'name' => 'Sastra Indonesia']);
        Jurusan::create(['fakultas_id' => $fib->id, 'name' => 'Sastra Inggris']);
        Jurusan::create(['fakultas_id' => $fib->id, 'name' => 'Sastra Jepang']);
        Jurusan::create(['fakultas_id' => $fib->id, 'name' => 'Sastra Arab']);
        Jurusan::create(['fakultas_id' => $fib->id, 'name' => 'Bahasa dan Kebudayaan Tiongkok']);
        Jurusan::create(['fakultas_id' => $fib->id, 'name' => 'Sastra Daerah']);
        Jurusan::create(['fakultas_id' => $fib->id, 'name' => 'Sastra Sejarah']);
        Jurusan::create(['fakultas_id' => $fib->id, 'name' => 'Sastra Arkeologi']);
        Jurusan::create(['fakultas_id' => $fib->id, 'name' => 'Pariwisata']);

        $faperta = Fakultas::create(['name' => 'Fakultas Pertanian']);
        Jurusan::create(['fakultas_id' => $faperta->id, 'name' => 'Agroteknologi']);
        Jurusan::create(['fakultas_id' => $faperta->id, 'name' => 'Ilmu Tanah']);
        Jurusan::create(['fakultas_id' => $faperta->id, 'name' => 'Agribisnis']);
        Jurusan::create(['fakultas_id' => $faperta->id, 'name' => 'Proteksi Tanaman']);
        Jurusan::create(['fakultas_id' => $faperta->id, 'name' => 'Pemuliaan dan Bioteknologi Tanaman']);
        Jurusan::create(['fakultas_id' => $faperta->id, 'name' => 'Pembangunan Pertanian']);

        $fmipa = Fakultas::create(['name' => 'Fakultas Matematika dan Ilmu Pengetahuan Alam']);
        Jurusan::create(['fakultas_id' => $fmipa->id, 'name' => 'Matematika']);
        Jurusan::create(['fakultas_id' => $fmipa->id, 'name' => 'Fisika']);
        Jurusan::create(['fakultas_id' => $fmipa->id, 'name' => 'Kimia']);
        Jurusan::create(['fakultas_id' => $fmipa->id, 'name' => 'Biologi']);
        Jurusan::create(['fakultas_id' => $fmipa->id, 'name' => 'Geofisika']);
        Jurusan::create(['fakultas_id' => $fmipa->id, 'name' => 'Aktuaria']);
        Jurusan::create(['fakultas_id' => $fmipa->id, 'name' => 'Statistika']);
        Jurusan::create(['fakultas_id' => $fmipa->id, 'name' => 'Sistem Informasi']);

        $fapet = Fakultas::create(['name' => 'Fakultas Peternakan']);
        Jurusan::create(['fakultas_id' => $fapet->id, 'name' => 'Peternakan']);

        $fkg = Fakultas::create(['name' => 'Fakultas Kedokteran Gigi']);
        Jurusan::create(['fakultas_id' => $fkg->id, 'name' => 'Pendidikano Dokter Gigi']);

        $fkm = Fakultas::create(['name' => 'Fakultas Kesehatan Masyarakat']);
        Jurusan::create(['fakultas_id' => $fkm->id, 'name' => 'Kesehatan Masyarakat']);
        Jurusan::create(['fakultas_id' => $fkm->id, 'name' => 'Ilmu Gizi']);

        $fikp = Fakultas::create(['name' => 'Fakultas Ilmu Kelautan dan Perikanan']);
        Jurusan::create(['fakultas_id' => $fikp->id, 'name' => 'Ilmu Kelautan']);
        Jurusan::create(['fakultas_id' => $fikp->id, 'name' => 'Manajemen Sumber Daya Perairan']);
        Jurusan::create(['fakultas_id' => $fikp->id, 'name' => 'Budidaya Perairan']);
        Jurusan::create(['fakultas_id' => $fikp->id, 'name' => 'Sosial Ekonomi Perikanan']);
        Jurusan::create(['fakultas_id' => $fikp->id, 'name' => 'Pemanfaatan Sumber Daya Perikanan']);
        Jurusan::create(['fakultas_id' => $fikp->id, 'name' => 'Teknologi Hasil Perikanan']);

        $fhut = Fakultas::create(['name' => 'Fakultas Kehutanan']);
        Jurusan::create(['fakultas_id' => $fhut->id, 'name' => 'Kehutanan']);
        Jurusan::create(['fakultas_id' => $fhut->id, 'name' => 'Rekayasa Kehutanan']);
        Jurusan::create(['fakultas_id' => $fhut->id, 'name' => 'Konservasi Hutan']);

        $farmasi = Fakultas::create(['name' => 'Fakultas Farmasi']);
        Jurusan::create(['fakultas_id' => $farmasi->id, 'name' => 'Farmasi']);

        $keperawatan = Fakultas::create(['name' => 'Fakultas Keperawatan']);
        Jurusan::create(['fakultas_id' => $keperawatan->id, 'name' => 'Ilmu Keperawatan']);
        Jurusan::create(['fakultas_id' => $keperawatan->id, 'name' => 'Fisioterapi']);

        $fateta = Fakultas::create(['name' => 'Fakultas Teknologi Pertanian']);
        Jurusan::create(['fakultas_id' => $fateta->id, 'name' => 'Teknik Pertanian']);
        Jurusan::create(['fakultas_id' => $fateta->id, 'name' => 'ilmu dan Teknologi Pangan']);
        Jurusan::create(['fakultas_id' => $fateta->id, 'name' => 'Teknologi Industri Pertanian']);

        $vokasi = Fakultas::create(['name' => 'Fakultas Vokasi']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Teknologi Produksi Ternak']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Teknologi Produksi Tanaman Pangan']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Teknologi Pakan dan Ternak']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Agribisnis Peternakan']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Agribisnis Pangan']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Terapi Gigi']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Destinasi Pariwisata']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Budi Daya Laut dan Pantai']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Teknologi Akuakultur dan Pasca Panen Perikanan']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Paramedik Veteriner']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Teknologi Metalurgi Ekstraksi']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Pengindraan Jauh dan Sisten Geografis']);
        Jurusan::create(['fakultas_id' => $vokasi->id, 'name' => 'Komunikasi Digital']);

    }
}