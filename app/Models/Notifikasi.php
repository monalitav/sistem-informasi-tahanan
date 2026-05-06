<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahanan_id',
        'jenis',
        'tanggal_target',
        'pesan',
        'terbaca_at',
    ];

    protected $casts = [
        'tanggal_target' => 'date',
        'terbaca_at' => 'datetime',
    ];

    public function tahanan(): BelongsTo
    {
        return $this->belongsTo(Tahanan::class);
    }

    public function scopeUntukTahananAktif(Builder $query): Builder
    {
        return $query->whereHas('tahanan', fn (Builder $q) => $q->where('status', 'aktif'));
    }

    public function scopeDalamRentangKeluar(Builder $query, ?Carbon $today = null, int $days = 7): Builder
    {
        $today = ($today ?? now())->startOfDay();
        $endDate = $today->copy()->addDays($days)->endOfDay();

        return $query
            ->whereDate('tanggal_target', '>=', $today->toDateString())
            ->whereDate('tanggal_target', '<=', $endDate->toDateString());
    }
}
