<?php

namespace App\Filament\Resources\TahananResource\Pages;

use App\Filament\Resources\TahananResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTahanan extends ViewRecord
{
    protected static string $resource = TahananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
