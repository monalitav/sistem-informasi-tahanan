<?php

namespace App\Filament\Resources\TahananResource\Pages;

use App\Filament\Resources\TahananResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTahanans extends ListRecords
{
    protected static string $resource = TahananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data Tahanan'),
        ];
    }
}
