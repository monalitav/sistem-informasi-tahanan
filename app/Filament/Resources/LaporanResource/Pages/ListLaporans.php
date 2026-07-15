<?php

namespace App\Filament\Resources\LaporanResource\Pages;

use App\Filament\Resources\LaporanResource;
use App\Models\Pengaturan;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListLaporans extends ListRecords
{
    protected static string $resource = LaporanResource::class;
    protected static string $view = 'filament.resources.laporan.pages.list-laporans';

    // Use simple query string parameters
    protected $queryString = [
        'bulan' => ['except' => ''],
        'status' => ['except' => ''],
        'sort' => ['except' => 'tanggal_keluar'],
        'order' => ['except' => 'desc'],
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public $bulan = '';
    public $status = '';
    public $sort = 'tanggal_keluar';
    public $order = 'desc';
    public $search = '';

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('export')
                ->label('Export Excel')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $records = $this->getTableQuery()->get();

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

                    return response()->streamDownload($callback, $filename, $headers);
                }),

            \Filament\Actions\Action::make('export_pdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-arrow-down')
                ->color('danger')
                ->action(function () {
                    $records = $this->getTableQuery()->get();

                    $pengaturan = Pengaturan::current();

                    $logoPath = public_path('images/logo.png');

                    $logoBase64 = file_exists($logoPath)
                        ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath))
                        : null;

                    $filterLabel = null;

                    if (filled($this->bulan)) {
                        $bulanLabel = [
                            '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April',
                            '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus',
                            '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
                        ][$this->bulan] ?? null;

                        $filterLabel = 'Bulan Masuk: ' . $bulanLabel;
                    }

                    $pdf = Pdf::loadView('laporan.pdf', [
                        'records' => $records,
                        'pengaturan' => $pengaturan,
                        'logoBase64' => $logoBase64,
                        'filterLabel' => $filterLabel,
                        'tempatTandaTangan' => 'Malang',
                    ])->setPaper('a4', 'portrait');

                    $filename = 'laporan-tahanan-' . now()->format('Y-m-d-His') . '.pdf';

                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        $filename,
                    );
                }),
        ];
    }

    public function clearFilters(): void
    {
        $this->bulan = '';
        $this->status = '';
        $this->search = '';
        $this->resetPage();
    }

    public function sortBy($column): void
    {
        if ($this->sort === $column) {
            $this->order = $this->order === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort = $column;
            $this->order = 'asc';
        }
        $this->resetPage();
    }

    protected function getTableQuery(): Builder
    {
        $query = static::getResource()::getEloquentQuery();

        // Apply month filter
        if ($this->bulan) {
            $query->whereMonth('tanggal_masuk', (int) $this->bulan);
        }

        // Apply status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Apply search
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('nomor_registrasi', 'like', '%' . $this->search . '%')
                  ->orWhere('nik', 'like', '%' . $this->search . '%');
            });
        }

        // Apply sorting
        $allowedSortColumns = [
            'nomor_registrasi',
            'nik',
            'nama',
            'tanggal_masuk',
            'tanggal_keluar',
            'status'
        ];
        
        if (in_array($this->sort, $allowedSortColumns) && in_array($this->order, ['asc', 'desc'])) {
            $query->orderBy($this->sort, $this->order);
        }

        return $query;
    }

    public function getTableRecords(): \Illuminate\Contracts\Pagination\Paginator
    {
        return $this->getTableQuery()->paginate(10);
    }
}