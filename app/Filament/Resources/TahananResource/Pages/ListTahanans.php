<?php

namespace App\Filament\Resources\TahananResource\Pages;

use App\Filament\Resources\TahananResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTahanans extends ListRecords
{
    protected static string $resource = TahananResource::class;
    protected static string $view = 'filament.resources.tahanan.pages.list-tahanans';

    // Use simple query string parameters
    protected $queryString = [
        'status' => ['except' => ''],
        'keluar_7_hari' => ['except' => ''],
        'sort' => ['except' => 'nomor_registrasi'],
        'order' => ['except' => 'asc'],
        'search' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public $status = '';
    public $keluar_7_hari = '';
    public $sort = 'nomor_registrasi';
    public $order = 'asc';
    public $search = '';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data Tahanan'),
        ];
    }

    public function applyFilter($filter, $value): void
    {
        $this->{$filter} = $value;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->status = '';
        $this->keluar_7_hari = '';
        $this->search = '';
        $this->resetPage();
    }

    public function toggleKeluar7Hari(): void
    {
        $this->keluar_7_hari = $this->keluar_7_hari === 'true' ? '' : 'true';
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

        // Apply status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Apply 7-day release filter
        if ($this->keluar_7_hari === 'true') {
            $today = now()->startOfDay();
            $end = now()->startOfDay()->addDays(7)->endOfDay();
            
            $query->where('status', 'aktif')
                ->whereBetween('tanggal_keluar', [$today->toDateString(), $end->toDateString()]);
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
            'nama',
            'nik',
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
