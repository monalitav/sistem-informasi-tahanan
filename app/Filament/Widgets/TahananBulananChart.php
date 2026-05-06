<?php

namespace App\Filament\Widgets;

use App\Models\Tahanan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TahananBulananChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Jumlah Bulanan';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 1;

    public function getHeading(): string
    {
        return 'Grafik Jumlah Bulanan ('.now()->year.')';
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $year = now()->year;

        $masuk = Tahanan::query()
            ->selectRaw('MONTH(tanggal_masuk) as month, COUNT(*) as total')
            ->whereYear('tanggal_masuk', $year)
            ->groupBy(DB::raw('MONTH(tanggal_masuk)'))
            ->pluck('total', 'month')
            ->all();

        $keluar = Tahanan::query()
            ->selectRaw('MONTH(tanggal_keluar) as month, COUNT(*) as total')
            ->whereNotNull('tanggal_keluar')
            ->whereYear('tanggal_keluar', $year)
            ->groupBy(DB::raw('MONTH(tanggal_keluar)'))
            ->pluck('total', 'month')
            ->all();

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $masukData = [];
        $keluarData = [];
        for ($m = 1; $m <= 12; $m++) {
            $masukData[] = (int) ($masuk[$m] ?? 0);
            $keluarData[] = (int) ($keluar[$m] ?? 0);
        }

        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Masuk',
                    'data' => $masukData,
                    'backgroundColor' => 'rgba(99, 102, 241, 0.55)',
                    'borderColor' => 'rgba(99, 102, 241, 1)',
                ],
                [
                    'label' => 'Keluar',
                    'data' => $keluarData,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.45)',
                    'borderColor' => 'rgba(34, 197, 94, 1)',
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
