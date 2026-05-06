<?php

namespace App\Filament\Widgets;

use App\Models\Tahanan;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TahananOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Tahanan', Tahanan::query()->count())
                ->icon('heroicon-o-user-group')
                ->color(Color::Indigo)
                ->extraAttributes([
                    'style' => 'background: linear-gradient(135deg, rgba(99,102,241,.22), rgba(17,24,39,.65)); border: 1px solid rgba(99,102,241,.18);',
                ]),
            Stat::make('Data Tahanan Aktif', Tahanan::query()->where('status', 'aktif')->count())
                ->icon('heroicon-o-check-circle')
                ->color(Color::Green)
                ->extraAttributes([
                    'style' => 'background: linear-gradient(135deg, rgba(34,197,94,.22), rgba(17,24,39,.65)); border: 1px solid rgba(34,197,94,.18);',
                ]),
            Stat::make('Data Tahanan Keluar', Tahanan::query()->where('status', 'keluar')->count())
                ->icon('heroicon-o-arrow-left-on-rectangle')
                ->color(Color::Amber)
                ->extraAttributes([
                    'style' => 'background: linear-gradient(135deg, rgba(245,158,11,.22), rgba(17,24,39,.65)); border: 1px solid rgba(245,158,11,.18);',
                ]),
        ];
    }
}
