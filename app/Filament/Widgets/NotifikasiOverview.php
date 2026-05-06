<?php

namespace App\Filament\Widgets;

use App\Models\Notifikasi;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class NotifikasiOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $keluarHariIni = Notifikasi::query()
            ->untukTahananAktif()
            ->dalamRentangKeluar()
            ->whereNull('terbaca_at')
            ->where('jenis', 'keluar_hari_ini')
            ->count();

        $keluar7Hari = Notifikasi::query()
            ->untukTahananAktif()
            ->dalamRentangKeluar()
            ->whereNull('terbaca_at')
            ->where('jenis', 'keluar_7_hari')
            ->count();

        $totalBelumDibaca = Notifikasi::query()
            ->untukTahananAktif()
            ->dalamRentangKeluar()
            ->whereNull('terbaca_at')
            ->count();

        return [
            Stat::make('Belum Dibaca', $totalBelumDibaca)
                ->icon('heroicon-o-bell-alert')
                ->color(Color::Indigo)
                ->extraAttributes([
                    'style' => 'background: linear-gradient(135deg, rgba(99,102,241,.22), rgba(17,24,39,.65)); border: 1px solid rgba(99,102,241,.18);',
                ]),
            Stat::make('Keluar Hari Ini', $keluarHariIni)
                ->icon('heroicon-o-exclamation-triangle')
                ->color(Color::Red)
                ->extraAttributes([
                    'style' => 'background: linear-gradient(135deg, rgba(239,68,68,.22), rgba(17,24,39,.65)); border: 1px solid rgba(239,68,68,.18);',
                ]),
            Stat::make('Keluar kurang dari 7 hari', $keluar7Hari)
                ->icon('heroicon-o-clock')
                ->color(Color::Amber)
                ->extraAttributes([
                    'style' => 'background: linear-gradient(135deg, rgba(245,158,11,.22), rgba(17,24,39,.65)); border: 1px solid rgba(245,158,11,.18);',
                ]),
        ];
    }
}
