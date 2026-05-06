<?php

namespace App\Filament\Widgets;

use App\Models\Tahanan;
use Filament\Widgets\ChartWidget;

class StatusTahananChart extends ChartWidget
{
    protected static ?string $heading = 'Diagram Status Tahanan';

    protected int|string|array $columnSpan = 1;

    protected static ?int $sort = 3;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $aktif = Tahanan::query()->where('status', 'aktif')->count();
        $keluar = Tahanan::query()->where('status', 'keluar')->count();

        return [
            'labels' => ['Aktif', 'Keluar'],
            'datasets' => [
                [
                    'label' => 'Jumlah',
                    'data' => [$aktif, $keluar],
                    'backgroundColor' => ['#22c55e', '#64748b'],
                    'borderColor' => ['#22c55e', '#64748b'],
                ],
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
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
