<?php

namespace App\Filament\Widgets;

use App\Models\Tahanan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TahananTahunanChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Jumlah Tahanan (5 Tahun Terakhir)';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 1;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $currentYear = now()->year;
        $years = range($currentYear - 4, $currentYear);

        $masuk = Tahanan::query()
            ->selectRaw('YEAR(tanggal_masuk) as year, COUNT(*) as total')
            ->whereNotNull('tanggal_masuk')
            ->whereBetween(DB::raw('YEAR(tanggal_masuk)'), [$currentYear - 4, $currentYear])
            ->groupBy(DB::raw('YEAR(tanggal_masuk)'))
            ->pluck('total', 'year')
            ->all();

        $keluar = Tahanan::query()
            ->selectRaw('YEAR(tanggal_keluar) as year, COUNT(*) as total')
            ->whereNotNull('tanggal_keluar')
            ->whereBetween(DB::raw('YEAR(tanggal_keluar)'), [$currentYear - 4, $currentYear])
            ->groupBy(DB::raw('YEAR(tanggal_keluar)'))
            ->pluck('total', 'year')
            ->all();

        $masukData = [];
        $keluarData = [];
        foreach ($years as $year) {
            $masukData[] = (int) ($masuk[$year] ?? 0);
            $keluarData[] = (int) ($keluar[$year] ?? 0);
        }

        return [
            'labels' => array_map(fn (int $y) => (string) $y, $years),
            'datasets' => [
                [
                    'label' => 'Masuk',
                    'data' => $masukData,
                    'borderColor' => 'rgba(99, 102, 241, 1)',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.25)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
                [
                    'label' => 'Keluar',
                    'data' => $keluarData,
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.18)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}
