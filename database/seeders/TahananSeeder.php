<?php

namespace Database\Seeders;

use App\Models\Tahanan;
use App\Services\TahananReleaseScanner;
use Illuminate\Database\Seeder;

class TahananSeeder extends Seeder
{
    public function run(): void
    {
        $today = now()->startOfDay();

        $rows = [
            [
                'nomor_registrasi' => 'THN-0001',
                'nama' => 'Andi Saputra',
                'nama_alias' => 'Andi',
                'nik' => '3276010101010001',
                'jenis_kelamin' => 'L',
                'pekerjaan' => 'Buruh',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => $today->copy()->subYears(30)->toDateString(),
                'alamat' => 'Jl. Merdeka No. 1',
                'alamat_terakhir' => 'Jl. Merdeka No. 1',
                'nama_ayah' => 'Slamet',
                'pasal' => 'Pasal 362',
                'jenis_kejahatan' => 'Pencurian',
                'pasal_yang_dilanggar' => 'Pasal 362 KUHP',
                'modus_operandi' => 'Mengambil barang tanpa izin di area umum.',
                'nomor_sprint' => 'SPRINT-001',
                'tanggal_sprint' => $today->copy()->subDays(10)->toDateString(),
                'tanggal_masuk' => $today->copy()->subDays(10)->toDateString(),
                'tanggal_keluar' => $today->toDateString(),
                'status' => 'aktif',
                'keterangan' => 'Data testing (keluar hari ini)',
            ],
            [
                'nomor_registrasi' => 'THN-0002',
                'nama' => 'Siti Aminah',
                'nama_alias' => 'Siti',
                'nik' => '3276010101010002',
                'jenis_kelamin' => 'P',
                'pekerjaan' => 'Karyawan',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => $today->copy()->subYears(28)->toDateString(),
                'alamat' => 'Jl. Sudirman No. 2',
                'alamat_terakhir' => 'Jl. Sudirman No. 2',
                'nama_ayah' => 'Herman',
                'pasal' => 'Pasal 351',
                'jenis_kejahatan' => 'Penganiayaan',
                'pasal_yang_dilanggar' => 'Pasal 351 KUHP',
                'modus_operandi' => 'Perkelahian di tempat umum.',
                'nomor_sprint' => 'SPRINT-002',
                'tanggal_sprint' => $today->copy()->subDays(20)->toDateString(),
                'tanggal_masuk' => $today->copy()->subDays(20)->toDateString(),
                'tanggal_keluar' => $today->copy()->addDays(5)->toDateString(),
                'status' => 'aktif',
                'keterangan' => 'Data testing (keluar kurang dari 7 hari)',
            ],
            [
                'nomor_registrasi' => 'THN-0006',
                'nama' => 'Fajar Nugraha',
                'nik' => '3276010101010006',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Pajajaran No. 6',
                'pasal' => 'Pasal 362',
                'tanggal_masuk' => $today->copy()->subDays(12)->toDateString(),
                'tanggal_keluar' => $today->copy()->addDays(1)->toDateString(),
                'status' => 'aktif',
                'keterangan' => 'Data testing (keluar H+1)',
            ],
            [
                'nomor_registrasi' => 'THN-0007',
                'nama' => 'Rizky Pratama',
                'nik' => '3276010101010007',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Braga No. 7',
                'pasal' => 'Pasal 351',
                'tanggal_masuk' => $today->copy()->subDays(14)->toDateString(),
                'tanggal_keluar' => $today->copy()->addDays(2)->toDateString(),
                'status' => 'aktif',
                'keterangan' => 'Data testing (keluar H+2)',
            ],
            [
                'nomor_registrasi' => 'THN-0008',
                'nama' => 'Putri Maharani',
                'nik' => '3276010101010008',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Riau No. 8',
                'pasal' => 'Pasal 480',
                'tanggal_masuk' => $today->copy()->subDays(18)->toDateString(),
                'tanggal_keluar' => $today->copy()->addDays(3)->toDateString(),
                'status' => 'aktif',
                'keterangan' => 'Data testing (keluar H+3)',
            ],
            [
                'nomor_registrasi' => 'THN-0009',
                'nama' => 'Dimas Saputra',
                'nik' => '3276010101010009',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Setiabudi No. 9',
                'pasal' => 'Pasal 378',
                'tanggal_masuk' => $today->copy()->subDays(22)->toDateString(),
                'tanggal_keluar' => $today->copy()->addDays(4)->toDateString(),
                'status' => 'aktif',
                'keterangan' => 'Data testing (keluar H+4)',
            ],
            [
                'nomor_registrasi' => 'THN-0010',
                'nama' => 'Nanda Lestari',
                'nik' => '3276010101010010',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Cihampelas No. 10',
                'pasal' => 'Pasal 363',
                'tanggal_masuk' => $today->copy()->subDays(8)->toDateString(),
                'tanggal_keluar' => $today->copy()->addDays(6)->toDateString(),
                'status' => 'aktif',
                'keterangan' => 'Data testing (keluar H+6)',
            ],
            [
                'nomor_registrasi' => 'THN-0011',
                'nama' => 'Agus Permana',
                'nik' => '3276010101010011',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Dago No. 11',
                'pasal' => 'Pasal 362',
                'tanggal_masuk' => $today->copy()->subDays(16)->toDateString(),
                'tanggal_keluar' => $today->copy()->addDays(7)->toDateString(),
                'status' => 'aktif',
                'keterangan' => 'Data testing (keluar H+7)',
            ],
            [
                'nomor_registrasi' => 'THN-0003',
                'nama' => 'Budi Santoso',
                'nik' => '3276010101010003',
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Asia Afrika No. 3',
                'pasal' => 'Pasal 378',
                'tanggal_masuk' => $today->copy()->subDays(15)->toDateString(),
                'tanggal_keluar' => $today->copy()->addDays(30)->toDateString(),
                'status' => 'aktif',
                'keterangan' => 'Data testing (tidak masuk notifikasi)',
            ],
            [
                'nomor_registrasi' => 'THN-0004',
                'nama' => 'Rina Wulandari',
                'nik' => '3276010101010004',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Diponegoro No. 4',
                'pasal' => 'Pasal 363',
                'tanggal_masuk' => $today->copy()->subDays(40)->toDateString(),
                'tanggal_keluar' => $today->copy()->subDays(1)->toDateString(),
                'status' => 'aktif',
                'keterangan' => 'Data testing (sudah lewat)',
            ],
            [
                'nomor_registrasi' => 'THN-0005',
                'nama' => 'Dewi Lestari',
                'nik' => '3276010101010005',
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Gatot Subroto No. 5',
                'pasal' => 'Pasal 480',
                'tanggal_masuk' => $today->copy()->subDays(60)->toDateString(),
                'tanggal_keluar' => $today->copy()->subDays(3)->toDateString(),
                'status' => 'keluar',
                'keterangan' => 'Data testing (status keluar)',
            ],
        ];

        foreach ($rows as $row) {
            Tahanan::query()->updateOrCreate(
                ['nomor_registrasi' => $row['nomor_registrasi']],
                $row,
            );
        }

        app(TahananReleaseScanner::class)->scan($today);
    }
}
