<?php

namespace App\Filament\Pages;

use App\Models\Tahanan;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class Laporan extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Laporan';

    protected static ?int $navigationSort = 5;

    protected static string $view = 'filament.pages.laporan';

    public function getSubheading(): ?string
    {
        return 'Rekapitulasi data tahanan dan statistik harian/bulanan.';
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(Tahanan::query())
            ->columns([
                Tables\Columns\TextColumn::make('nomor_registrasi')
                    ->label('No. Registrasi')
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_masuk')
                    ->label('Masuk')
                    ->date('d-m-Y')
                    ->sortable()
                    ->icon('heroicon-m-calendar-days'),
                Tables\Columns\TextColumn::make('tanggal_keluar')
                    ->label('Keluar')
                    ->date('d-m-Y')
                    ->sortable()
                    ->icon('heroicon-m-arrow-right-start-on-rectangle'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aktif' => 'success',
                        'keluar' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function () {
                        $records = Tahanan::all();

                        $filename = 'laporan-tahanan-'.now()->format('Y-m-d-His').'.csv';

                        $headers = [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => "attachment; filename=\"$filename\"",
                        ];

                        $callback = function () use ($records) {
                            $file = fopen('php://output', 'w');

                            // BOM for Excel UTF-8 support
                            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                            // Header CSV
                            fputcsv($file, [
                                'No. Registrasi',
                                'NIK',
                                'Nama',
                                'Tanggal Masuk',
                                'Tanggal Keluar',
                                'Status',
                                'Jenis Kejahatan',
                                'Pasal',
                                'Alamat',
                            ]);

                            foreach ($records as $record) {
                                fputcsv($file, [
                                    $record->nomor_registrasi,
                                    $record->nik,
                                    $record->nama,
                                    $record->tanggal_masuk,
                                    $record->tanggal_keluar,
                                    $record->status,
                                    $record->jenis_kejahatan,
                                    $record->pasal,
                                    $record->alamat,
                                ]);
                            }

                            fclose($file);
                        };

                        return response()->streamDownload($callback, $filename, $headers);
                    }),
            ])
            ->defaultSort('tanggal_keluar');
    }
}
