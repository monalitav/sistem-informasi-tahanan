<?php

namespace App\Filament\Widgets;

use App\Models\Notifikasi;
use App\Services\TahananReleaseScanner;
use Filament\Widgets\Widget;

class NotifikasiSingkat extends Widget
{
    protected static string $view = 'filament.widgets.notifikasi-singkat';

    protected int|string|array $columnSpan = 'full';

    protected static ?int $sort = 10;

    public function getRingkasanProperty(): array
    {
        app(TahananReleaseScanner::class)->scanIfDue();

        $baseQuery = Notifikasi::query()
            ->untukTahananAktif()
            ->dalamRentangKeluar()
            ->whereNull('terbaca_at')
            ->whereHas('tahanan');

        $keluarHariIni = (clone $baseQuery)
            ->where('jenis', 'keluar_hari_ini')
            ->count();

        $keluarKurang7Hari = (clone $baseQuery)
            ->where('jenis', 'keluar_7_hari')
            ->count();

        return [
            'keluar_hari_ini' => $keluarHariIni,
            'keluar_kurang_7_hari' => $keluarKurang7Hari,
        ];
    }
}
