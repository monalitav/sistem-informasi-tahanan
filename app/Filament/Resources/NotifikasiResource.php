<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NotifikasiResource\Pages;
use App\Models\Notifikasi;
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
        return $table
            ->recordUrl(fn (Notifikasi $record): string => TahananResource::getUrl('view', ['record' => $record->tahanan_id]))
            ->emptyStateHeading('Belum ada notifikasi')
            ->emptyStateDescription('Klik Refresh Data untuk mengecek tahanan yang keluar hari ini dan kurang dari 7 hari ke depan.')
            ->emptyStateIcon('heroicon-o-bell-slash')
            ->columns([
                Tables\Columns\TextColumn::make('tahanan.nomor_registrasi')
                    ->label('No. Registrasi')
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('tahanan.nama')
                    ->label('Nama')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenis')
                    ->badge()
                    ->formatStateUsing(function (string $state, Notifikasi $record): string {
                        if ($state === 'keluar_hari_ini') {
                            return 'Keluar hari ini';
                        }

                        if ($state === 'keluar_7_hari') {
                            $diff = $record->tanggal_target
                                ? now()->startOfDay()->diffInDays($record->tanggal_target, false)
                                : null;

                            $days = $diff !== null ? max(1, (int) $diff) : null;

                            return $days ? "Keluar kurang {$days} hari" : 'Keluar kurang dari 7 hari';
                        }

                        return $state;
                    })
                    ->color(fn (string $state): array|string|null => match ($state) {
                        'keluar_hari_ini' => Color::Red,
                        'keluar_7_hari' => Color::Amber,
                        default => null,
                    }),

                Tables\Columns\TextColumn::make('tanggal_target')
                    ->label('Tanggal')
                    ->date('d-m-Y')
                    ->description(fn (Notifikasi $record): ?string => $record->tanggal_target?->isToday() ? 'Hari ini' : null)
                    ->sortable()
                    ->icon('heroicon-m-calendar'),

                Tables\Columns\TextColumn::make('sisa_hari')
                    ->label('Sisa Hari')
                    ->state(fn (Notifikasi $record): ?int => $record->tanggal_target
                        ? now()->startOfDay()->diffInDays($record->tanggal_target, false)
                        : null)
                    ->badge()
                    ->formatStateUsing(fn (?int $state) =>
                        $state !== null
                            ? ($state == 0
                                ? 'Hari ini'
                                : ($state < 0
                                    ? 'Lewat ' . abs($state) . ' hari'
                                    : $state . ' hari lagi'))
                            : '-'
                    )
                    ->color(fn (?int $state): array|string|null => match (true) {
                        $state === null => null,
                        $state <= 0 => Color::Red,
                        $state <= 2 => Color::Amber,
                        default => Color::Green,
                    })
                    ->sortable(query: fn ($query, string $direction) => $query->orderBy('tanggal_target', $direction)),

                Tables\Columns\TextColumn::make('pesan')
                    ->wrap()
                    ->extraAttributes([
                        'style' => 'min-width: 400px;',
                    ])
                    ->tooltip(fn (Notifikasi $record): string => $record->pesan),

                Tables\Columns\IconColumn::make('is_terbaca')
                    ->label('Status')
                    ->getStateUsing(fn (Notifikasi $record): bool => $record->terbaca_at !== null)
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-exclamation-circle')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->sortable(query: fn ($query, string $direction) => $query->orderBy('terbaca_at', $direction)),

                Tables\Columns\TextColumn::make('terbaca_at')
                    ->label('Waktu Terbaca')
                    ->dateTime('d-m-Y H:i')
                    ->placeholder('-')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d-m-Y H:i')
                    ->sortable(),
            ])

            ->filters([
                Tables\Filters\TernaryFilter::make('is_terbaca')
                    ->label('Status Baca')
                    ->placeholder('Semua')
                    ->trueLabel('Sudah Dibaca')
                    ->falseLabel('Belum Dibaca')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('terbaca_at'),
                        false: fn (Builder $query) => $query->whereNull('terbaca_at'),
                    ),

                Tables\Filters\SelectFilter::make('jenis')
                    ->label('Jenis Notifikasi')
                    ->options([
                        'keluar_hari_ini' => 'Keluar hari ini',
                        'keluar_7_hari' => 'Keluar kurang dari 7 hari',
                    ]),
            ])

            ->actions([
                Tables\Actions\Action::make('lihat_tahanan')
                    ->label('Detail')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Notifikasi $record): string => TahananResource::getUrl('view', ['record' => $record->tahanan_id])),

                Tables\Actions\Action::make('tandai_dibaca')
                    ->label('Tandai dibaca')
                    ->icon('heroicon-o-check')
                    ->visible(fn (Notifikasi $record): bool => $record->terbaca_at === null)
                    ->action(fn (Notifikasi $record) => $record->update([
                        'terbaca_at' => now(),
                    ])),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('tandai_dibaca')
                        ->label('Tandai dibaca')
                        ->icon('heroicon-o-check')
                        ->action(fn ($records) => $records->each->update([
                            'terbaca_at' => now(),
                        ])),
                ]),
            ])

            ->defaultSort('tanggal_target', 'asc')

            ->modifyQueryUsing(function (Builder $query) {
                $search = request()->query('tableSearch');

                if (! $search) {
                    return $query;
                }

                return $query->where(function (Builder $query) use ($search) {
                    $query->whereHas('tahanan', function (Builder $query) use ($search) {
                        $query->where('nama', 'like', "%{$search}%")
                            ->orWhere('nomor_registrasi', 'like', "%{$search}%");
                    })
                    ->orWhere('jenis', 'like', "%{$search}%")
                    ->orWhere('pesan', 'like', "%{$search}%");
                });
            });
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotifikasis::route('/'),
        ];
    }
}