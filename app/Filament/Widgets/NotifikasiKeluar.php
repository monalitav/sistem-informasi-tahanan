<?php

namespace App\Filament\Widgets;

use App\Models\Notifikasi;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class NotifikasiKeluar extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Notifikasi::query()
                    ->with('tahanan')
                    ->untukTahananAktif()
                    ->dalamRentangKeluar()
                    ->orderBy('tanggal_target')
                    ->orderByDesc('created_at')
                    ->limit(7)
            )
            ->columns([
                Tables\Columns\TextColumn::make('tahanan.nama')
                    ->label('Nama')
                    ->wrap(),
                Tables\Columns\TextColumn::make('tanggal_target')
                    ->label('Tanggal')
                    ->date('d-m-Y'),
                Tables\Columns\TextColumn::make('jenis')
                    ->badge()
                    ->formatStateUsing(function (string $state, Notifikasi $record): string {
                        if ($state === 'keluar_hari_ini') {
                            return 'Keluar hari ini';
                        }

                        if ($state === 'keluar_7_hari') {
                            $diff = $record->tanggal_target
                                ? now()->startOfDay()->diffInDays($record->tanggal_target, false)
                                : null;
                            $days = $diff !== null ? max(1, (int) $diff) : null;

                            return $days ? "Keluar kurang {$days} hari" : 'Keluar kurang dari 7 hari';
                        }

                        return $state;
                    }),
                Tables\Columns\TextColumn::make('pesan')
                    ->wrap()
                    ->limit(120),
            ])
            ->paginated(false);
    }
}
