<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tahanan extends Model
{
    use HasFactory;

    protected $fillable = [
        // ======================
        // DATA DEMOGRAFI
        // ======================
        'nomor_registrasi',
        'nama',
        'nama_alias',
        'nik',
        'jenis_kelamin',
        'pekerjaan',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'alamat_terakhir',
        'nama_ayah',

        // ======================
        // DATA KRIMINAL
        // ======================
        'jenis_kejahatan',
        'pasal_yang_dilanggar',
        'pasal',
        'modus_operandi',
        'nomor_sprint',
        'tanggal_sprint',
        'tanggal_masuk',
        'tanggal_keluar',
        'status',
        'keterangan',

        // ======================
        // FOTO / BIOGRAFI
        // ======================
        'foto_sidik_jari',
        'foto_tampak_depan',
        'foto_samping_kanan',
        'foto_samping_kiri',

        // ======================
        // 
        // ======================
        'jempol_kanan',
        'telunjuk_kanan',
        'tengah_kanan',
        'manis_kanan',
        'kelingking_kanan',
        'jempol_kiri',
        'telunjuk_kiri',
        'tengah_kiri',
        'manis_kiri',
        'kelingking_kiri',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'tanggal_keluar' => 'date',
        'tanggal_lahir' => 'date',
        'tanggal_sprint' => 'date',
    ];

    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }
}