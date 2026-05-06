<?php

namespace App\Filament\Resources\TahananResource\Pages;

use App\Filament\Resources\TahananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTahanan extends EditRecord
{
    protected static string $resource = TahananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
