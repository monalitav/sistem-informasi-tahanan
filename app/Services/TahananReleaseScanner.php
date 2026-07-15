<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\Tahanan;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class TahananReleaseScanner
{
    /**
     * Runs scan() at most once per $throttleSeconds, so pages/widgets can call
     * this on every poll/render without hammering the database. This is what
     * keeps notifications up to date on environments without an OS-level cron
     * running `schedule:run`.
     */
    public function scanIfDue(int $throttleSeconds = 60): Collection
    {
        $cacheKey = 'tahanan-release-scan-last-run';

        if (Cache::has($cacheKey)) {
            return collect();
        }

        Cache::put($cacheKey, true, $throttleSeconds);

        return $this->scan();
    }

    public function scan(?Carbon $today = null): Collection
    {
        $today = ($today ?? now())->startOfDay();
        $endDate = $today->copy()->addDays(7)->endOfDay();

        Tahanan::query()
            ->where('status', 'aktif')
            ->whereDate('tanggal_keluar', '<', $today->toDateString())
            ->update(['status' => 'keluar']);

        Notifikasi::query()
            ->whereHas('tahanan', fn ($q) => $q->where('status', '!=', 'aktif'))
            ->delete();

        Notifikasi::query()
            ->where(function ($q) use ($today, $endDate) {
                $q->whereDate('tanggal_target', '<', $today->toDateString())
                    ->orWhereDate('tanggal_target', '>', $endDate->toDateString());
            })
            ->delete();

        $tahanans = Tahanan::query()
            ->where('status', 'aktif')
            ->orderBy('tanggal_keluar')
            ->get();

        $notifikasis = collect();

        foreach ($tahanans as $tahanan) {
            if (! $tahanan->tanggal_keluar) {
                continue;
            }

            $tanggalKeluar = Carbon::parse($tahanan->tanggal_keluar)->startOfDay();

            if ($tanggalKeluar->lt($today) || $tanggalKeluar->gt($endDate)) {
                continue;
            }

            $jenis = $tanggalKeluar->isSameDay($today) ? 'keluar_hari_ini' : 'keluar_7_hari';
            $pesan = $tanggalKeluar->isSameDay($today)
                ? "Tahanan {$tahanan->nama} ({$tahanan->nomor_registrasi}) keluar hari ini ({$tanggalKeluar->format('d-m-Y')})."
                : "Tahanan {$tahanan->nama} ({$tahanan->nomor_registrasi}) akan keluar pada {$tanggalKeluar->format('d-m-Y')}.";

            Notifikasi::query()
                ->where('tahanan_id', $tahanan->id)
                ->whereDate('tanggal_target', $tanggalKeluar->toDateString())
                ->where('jenis', '!=', $jenis)
                ->delete();

            $notifikasi = Notifikasi::query()->updateOrCreate(
                [
                    'tahanan_id' => $tahanan->id,
                    'jenis' => $jenis,
                    'tanggal_target' => $tanggalKeluar->toDateString(),
                ],
                [
                    'pesan' => $pesan,
                ],
            );

            $notifikasis->push($notifikasi);
        }

        return $notifikasis;
    }
}
