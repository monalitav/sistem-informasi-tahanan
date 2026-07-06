<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanResource\Pages;
use App\Models\Tahanan;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;

class LaporanResource extends Resource
{
    protected static ?string $model = Tahanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Laporan';

    protected static ?string $modelLabel = 'Laporan';

    protected static ?string $pluralModelLabel = 'Laporan Data Tahanan';

    protected static ?int $navigationSort = 5;

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Tahanan::query()
            )

            ->columns([

                Tables\Columns\TextColumn::make('nomor_registrasi')
                    ->label('No. Registrasi')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->date(),

                Tables\Columns\TextColumn::make('tanggal_keluar')
                    ->label('Tanggal Keluar')
                    ->date(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string =>
                        $state === 'aktif'
                            ? 'success'
                            : 'danger'
                    ),

            ])

            ->filters([

                SelectFilter::make('bulan')
                    ->label('Filter Bulan')
                    ->options([
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])

                    ->query(function (Builder $query, array $data): Builder {

                        if (! empty($data['value'])) {

                            $query->whereMonth(
                                'tanggal_masuk',
                                (int) $data['value']
                            );
                        }

                        return $query;
                    }),

                SelectFilter::make('status')
                    ->label('Status Tahanan')
                    ->options([
                        'aktif' => 'Aktif',
                        'keluar' => 'Keluar',
                    ]),
            ])

            ->headerActions([

                Tables\Actions\Action::make('export')

                    ->label('Export Excel')

                    ->icon('heroicon-o-arrow-down-tray')

                    ->color('success')

                    ->action(function () {

                        $records = Tahanan::all();

                        $filename = 'laporan-tahanan-' . now()->format('Y-m-d-His') . '.csv';

                        $headers = [
                            'Content-Type' => 'text/csv',
                            'Content-Disposition' => "attachment; filename=\"$filename\"",
                        ];

                        $callback = function () use ($records) {

                            $file = fopen('php://output', 'w');

                            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

                            fputcsv($file, [
                                'No Registrasi',
                                'NIK',
                                'Nama',
                                'Alamat',
                                'Jenis Kejahatan',
                                'Pasal',
                                'Tanggal Masuk',
                                'Tanggal Keluar',
                                'Status',
                            ]);

                            foreach ($records as $record) {

                                fputcsv($file, [
                                    $record->nomor_registrasi,
                                    $record->nik,
                                    $record->nama,
                                    $record->alamat,
                                    $record->jenis_kejahatan,
                                    $record->pasal,
                                    $record->tanggal_masuk,
                                    $record->tanggal_keluar,
                                    $record->status,
                                ]);
                            }

                            fclose($file);
                        };

                        return response()->streamDownload(
                            $callback,
                            $filename,
                            $headers
                        );
                    }),

            ])

            ->defaultSort('tanggal_keluar', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporans::route('/'),
        ];
    }
}