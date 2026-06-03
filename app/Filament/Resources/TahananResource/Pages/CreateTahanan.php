<?php

namespace App\Filament\Resources\TahananResource\Pages;

use App\Filament\Resources\TahananResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateTahanan extends CreateRecord
{
    protected static string $resource = TahananResource::class;

    protected static bool $canCreateAnother = false;

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    protected function getCreateFormAction(): Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan');
    }

    protected function getCancelFormAction(): Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }
}