<?php

namespace App\Filament\Resources\NotifikasiResource\Pages;

use App\Filament\Resources\NotifikasiResource;
use App\Services\TahananReleaseScanner;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListNotifikasis extends ListRecords
{
    protected static string $resource = NotifikasiResource::class;
    protected static string $view = 'filament.resources.notifikasi.pages.list-notifikasis';

    // Use simple query string parameters
    protected $queryString = [
        'is_terbaca' => ['except' => ''],
        'jenis' => ['except' => ''],
        'sort' => ['except' => 'tanggal_target'],
        'order' => ['except' => 'asc'],
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public $is_terbaca = '';
    public $jenis = '';
    public $sort = 'tanggal_target';
    public $order = 'asc';
    public $search = '';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('scan')
                ->label('Refresh Data')
                ->icon('heroicon-o-arrow-path')
                ->color('primary')
                ->action(function ($livewire) {
                    $count = app(TahananReleaseScanner::class)->scan()->count();

                    Notification::make()
                        ->title('Scan selesai')
                        ->body("Notifikasi dibuat/terverifikasi: {$count}")
                        ->success()
                        ->send();

                    return redirect(NotifikasiResource::getUrl('index'));
                }),
        ];
    }

    public function clearFilters(): void
    {
        $this->is_terbaca = '';
        $this->jenis = '';
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
        app(TahananReleaseScanner::class)->scanIfDue();

        $query = static::getResource()::getEloquentQuery();

        // Apply status terbaca filter
        if ($this->is_terbaca === 'true') {
            $query->whereNotNull('terbaca_at');
        } elseif ($this->is_terbaca === 'false') {
            $query->whereNull('terbaca_at');
        }

        // Apply jenis filter
        if ($this->jenis) {
            $query->where('jenis', $this->jenis);
        }

        // Apply search
        if ($this->search) {
            $query->where(function (Builder $q) {
                $q->whereHas('tahanan', function (Builder $q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                      ->orWhere('nomor_registrasi', 'like', '%' . $this->search . '%');
                })
                ->orWhere('jenis', 'like', '%' . $this->search . '%')
                ->orWhere('pesan', 'like', '%' . $this->search . '%');
            });
        }

        // Apply sorting
        $allowedSortColumns = [
            'tanggal_target',
            'created_at',
            'terbaca_at',
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