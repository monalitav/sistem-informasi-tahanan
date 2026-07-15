<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotifikasiResource\Pages;
use App\Models\Notifikasi;
use App\Services\TahananReleaseScanner;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class NotifikasiResource extends Resource
{
    protected static ?string $model = Notifikasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';

    protected static ?string $navigationLabel = 'Notifikasi';

    protected static ?string $pluralModelLabel = 'Notifikasi';

    protected static ?int $navigationSort = 4;

    public static function getNavigationBadge(): ?string
    {
        app(TahananReleaseScanner::class)->scanIfDue();

        $count = Notifikasi::query()
            ->untukTahananAktif()
            ->dalamRentangKeluar()
            ->whereNull('terbaca_at')
            ->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return Notifikasi::query()
            ->untukTahananAktif()
            ->dalamRentangKeluar()
            ->whereNull('terbaca_at')
            ->exists() ? 'danger' : 'gray';
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->untukTahananAktif()
            ->dalamRentangKeluar()
            ->orderBy('tanggal_target')
            ->orderByDesc('created_at');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        // Table definition not used - custom view implemented
        return $table->columns([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotifikasis::route('/'),
        ];
    }
}