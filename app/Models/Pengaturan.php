<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_instansi',
        'alamat_instansi',
        'telepon_instansi',
        'nama_penanggung_jawab',
        'pangkat_nrp_penanggung_jawab',
        'jabatan_penanggung_jawab',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
