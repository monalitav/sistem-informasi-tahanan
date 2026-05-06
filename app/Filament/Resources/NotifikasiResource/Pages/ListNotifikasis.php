<?php

namespace App\Filament\Resources\NotifikasiResource\Pages;

use App\Filament\Resources\NotifikasiResource;
use App\Services\TahananReleaseScanner;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListNotifikasis extends ListRecords
{
    protected static string $resource = NotifikasiResource::class;

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
}
