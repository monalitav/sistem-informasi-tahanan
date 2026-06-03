<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TahananResource\Pages;
use App\Models\Tahanan;

use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;

class TahananResource extends Resource
{
    protected static ?string $model = Tahanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Data Tahanan';

    protected static ?string $pluralModelLabel = 'Tahanan';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Data Tahanan')
                   ->columnSpanFull()
                    ->tabs([
                        Tab::make('Data Demografi')
                            ->schema([
                                TextInput::make('nomor_registrasi')
                                    ->label('No. Registrasi')
                                    ->required()
                                    ->maxLength(50)
                                    ->unique(ignoreRecord: true),
                                TextInput::make('nik')
                                    ->label('NIK')
                                    ->maxLength(32),
                                TextInput::make('nama')
                                    ->label('Nama Lengkap')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('nama_alias')
                                    ->label('Nama Alias')
                                    ->maxLength(255),
                                Select::make('jenis_kelamin')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'L' => 'Laki-laki',
                                        'P' => 'Perempuan',
                                    ])
                                    ->native(false),
                                TextInput::make('pekerjaan')
                                    ->label('Pekerjaan')
                                    ->maxLength(255),
                                TextInput::make('tempat_lahir')
                                    ->label('Tempat Lahir')
                                    ->maxLength(255),
                                DatePicker::make('tanggal_lahir')
                                    ->label('Tanggal Lahir')
                                    ->native(false),
                                Textarea::make('alamat')
                                    ->label('Alamat')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Textarea::make('alamat_terakhir')
                                    ->label('Alamat Terakhir')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('nama_ayah')
                                    ->label('Nama Ayah')
                                    ->maxLength(255),
                            ])
                            ->columns(2),
                        Tab::make('Data Catatan Kriminal')
                            ->schema([
                                TextInput::make('jenis_kejahatan')
                                    ->label('Jenis Kejahatan')
                                    ->maxLength(255),
                                TextInput::make('pasal_yang_dilanggar')
                                    ->label('Pasal yang Dilanggar')
                                    ->maxLength(255),
                                TextInput::make('pasal')
                                    ->label('Pasal (Singkat)')
                                    ->maxLength(255),
                                Textarea::make('modus_operandi')
                                    ->label('Modus Operandi')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                DatePicker::make('tanggal_masuk')
                                    ->label('Tanggal Masuk Tahanan')
                                    ->required()
                                    ->native(false),
                                DatePicker::make('tanggal_keluar')
                                    ->label('Tanggal Keluar')
                                    ->required()
                                    ->native(false),
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'aktif' => 'Aktif',
                                        'keluar' => 'Keluar',
                                    ])
                                    ->default('aktif')
                                    ->required()
                                    ->native(false),
                                TextInput::make('nomor_sprint')
                                    ->label('Nomor Sprint')
                                    ->maxLength(255),
                                DatePicker::make('tanggal_sprint')
                                    ->label('Tanggal Sprint')
                                    ->native(false),
                                TextInput::make('nomor_surat_penahanan')
                                    ->label('Nomor Surat Penahanan')
                                    ->maxLength(255),
                                TextInput::make('nomor_surat_penyitaan')
                                    ->label('Nomor Surat Penyitaan')
                                    ->maxLength(255),
                                Select::make('kesehatan')
                                    ->label('Status Kesehatan')
                                    ->options([
                                        'sehat' => 'Sehat',
                                        'sakit' => 'Sakit',
                                    ])
                                    ->default('sehat')
                                    ->required()
                                    ->native(false),
                                Textarea::make('keterangan')
                                    ->label('Keterangan')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),
                        Tab::make('Data Biografi')
                            ->schema([
                                FileUpload::make('foto_tampak_depan')
                                    ->label('Foto Tampak Depan')
                                    ->image()
                                    ->disk('public')
                                    ->directory('tahanan/biografi')
                                    ->visibility('public'),
                                FileUpload::make('foto_samping_kanan')
                                    ->label('Foto Samping Kanan')
                                    ->image()
                                    ->disk('public')
                                    ->directory('tahanan/biografi')
                                    ->visibility('public'),
                                FileUpload::make('foto_samping_kiri')
                                    ->label('Foto Samping Kiri')
                                    ->image()
                                    ->disk('public')
                                    ->directory('tahanan/biografi')
                                    ->visibility('public'),
                            ])
                            ->columns(2),
                         Tab::make('Sidik Jari')
                           ->schema([
                              FileUpload::make('jempol_kanan')
                                  ->label('Jempol Kanan')
                                  ->image()
                                  ->disk('public')
                                  ->directory('tahanan/sidik_jari')
                                  ->visibility('public'),

                             FileUpload::make('telunjuk_kanan')
                                ->label('Telunjuk Kanan')
                                ->image()
                                ->disk('public')
                                ->directory('tahanan/sidik_jari')
                                ->visibility('public'),

                            FileUpload::make('tengah_kanan')
                               ->label('Jari Tengah Kanan')
                               ->image()
                               ->disk('public')
                               ->directory('tahanan/sidik_jari')
                               ->visibility('public'),

                           FileUpload::make('manis_kanan')
                               ->label('Jari Manis Kanan')
                               ->image()
                               ->disk('public')
                               ->directory('tahanan/sidik_jari')
                               ->visibility('public'),

                            FileUpload::make('kelingking_kanan')
                               ->label('Kelingking Kanan')
                               ->image()
                               ->disk('public')
                               ->directory('tahanan/sidik_jari')
                               ->visibility('public'),

                            FileUpload::make('jempol_kiri')
                               ->label('Jempol Kiri')
                               ->image()
                               ->disk('public')
                               ->directory('tahanan/sidik_jari')
                               ->visibility('public'),

                            FileUpload::make('telunjuk_kiri')
                               ->label('Telunjuk Kiri')
                               ->image()
                               ->disk('public')
                               ->directory('tahanan/sidik_jari')
                               ->visibility('public'),

                            FileUpload::make('tengah_kiri')
                              ->label('Jari Tengah Kiri')
                              ->image()
                              ->disk('public')
                              ->directory('tahanan/sidik_jari')
                              ->visibility('public'),

                            FileUpload::make('manis_kiri')
                              ->label('Jari Manis Kiri')
                              ->image()
                              ->disk('public')
                              ->directory('tahanan/sidik_jari')
                             ->visibility('public'),

                             FileUpload::make('kelingking_kiri')
                              ->label('Kelingking Kiri')
                              ->image()
                              ->disk('public')
                              ->directory('tahanan/sidik_jari')
                              ->visibility('public'),
                   ])
                      ->columns(2)
                    ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Data Demografi')
                    ->schema([
                        TextEntry::make('nik')->label('NIK')->placeholder('-'),
                        TextEntry::make('nama')->label('Nama Lengkap'),
                        TextEntry::make('nama_alias')->label('Nama Alias')->placeholder('-'),
                        TextEntry::make('pekerjaan')->label('Pekerjaan')->placeholder('-'),
                        TextEntry::make('tempat_lahir')->label('Tempat Lahir')->placeholder('-'),
                        TextEntry::make('tanggal_lahir')->label('Tanggal Lahir')->date('d-m-Y')->placeholder('-'),
                        TextEntry::make('alamat')->label('Alamat')->placeholder('-')->columnSpanFull(),
                        TextEntry::make('alamat_terakhir')->label('Alamat Terakhir')->placeholder('-')->columnSpanFull(),
                        TextEntry::make('nama_ayah')->label('Nama Ayah')->placeholder('-'),
                    ])
                    ->columns(4),
                Section::make('Data Catatan Kriminal')
                    ->schema([
                        TextEntry::make('jenis_kejahatan')->label('Jenis Kejahatan')->placeholder('-'),
                        TextEntry::make('pasal_yang_dilanggar')->label('Pasal yang Dilanggar')->placeholder('-'),
                        TextEntry::make('modus_operandi')->label('Modus Operandi')->placeholder('-')->columnSpanFull(),
                        TextEntry::make('tanggal_masuk')->label('Tanggal Masuk')->date('d-m-Y')->placeholder('-'),
                        TextEntry::make('tanggal_keluar')->label('Tanggal Keluar')->date('d-m-Y')->placeholder('-'),
                        TextEntry::make('nomor_sprint')->label('Nomor Sprint')->placeholder('-'),
                        TextEntry::make('tanggal_sprint')->label('Tanggal Sprint')->date('d-m-Y')->placeholder('-'),
                        TextEntry::make('status')->label('Status')->badge(),
                    ])
                    ->columns(2),
              Section::make('Data Biografi')
    ->schema([
        ImageEntry::make('foto_tampak_depan')
            ->label('Tampak Depan')
            ->url(fn ($record) => asset('storage/' . $record->foto_tampak_depan))
            ->height(150)
            ->placeholder('-'),

        ImageEntry::make('foto_samping_kanan')
            ->label('Samping Kanan')
            ->url(fn ($record) => asset('storage/' . $record->foto_samping_kanan))
            ->height(150)
            ->placeholder('-'),

        ImageEntry::make('foto_samping_kiri')
            ->label('Samping Kiri')
            ->url(fn ($record) => asset('storage/' . $record->foto_samping_kiri))
            ->height(150)
            ->placeholder('-'),
    ])
    ->columns(2),
             Section::make('Sidik Jari')
                ->schema([
                    ImageEntry::make('jempol_kanan')->label('Jempol Kanan')->url(fn ($record) => asset('storage/' . $record->jempol_kanan))->height(120)->placeholder('-'),
                    ImageEntry::make('telunjuk_kanan')->label('Telunjuk Kanan')->url(fn ($record) => asset('storage/' . $record->telunjuk_kanan))->height(120)->placeholder('-'),
                    ImageEntry::make('tengah_kanan')->label('Jari Tengah Kanan')->url(fn ($record) => asset('storage/' . $record->tengah_kanan))->height(120)->placeholder('-'),
                    ImageEntry::make('manis_kanan')->label('Jari Manis Kanan')->url(fn ($record) => asset('storage/' . $record->manis_kanan))->height(120)->placeholder('-'),
                    ImageEntry::make('kelingking_kanan')->label('Kelingking Kanan')->url(fn ($record) => asset('storage/' . $record->kelingking_kanan))->height(120)->placeholder('-'),

                    ImageEntry::make('jempol_kiri')->label('Jempol Kiri')->url(fn ($record) => asset('storage/' . $record->jempol_kiri))->height(120)->placeholder('-'),
                    ImageEntry::make('telunjuk_kiri')->label('Telunjuk Kiri')->url(fn ($record) => asset('storage/' . $record->telunjuk_kiri))->height(120)->placeholder('-'),
                    ImageEntry::make('tengah_kiri')->label('Jari Tengah Kiri')->url(fn ($record) => asset('storage/' . $record->tengah_kiri))->height(120)->placeholder('-'),
                    ImageEntry::make('manis_kiri')->label('Jari Manis Kiri')->url(fn ($record) => asset('storage/' . $record->manis_kiri))->height(120)->placeholder('-'),
                    ImageEntry::make('kelingking_kiri')->label('Kelingking Kiri')->url(fn ($record) => asset('storage/' . $record->kelingking_kiri))->height(120)->placeholder('-'),
                ])
                ->columns(2),

        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_registrasi')
                    ->label('No. Registrasi')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tanggal_masuk')
                    ->label('Masuk')
                    ->date('d-m-Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_keluar')
                    ->label('Keluar')
                    ->date('d-m-Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): array|string|null => match ($state) {
                        'aktif' => Color::Green,
                        'keluar' => Color::Gray,
                        default => null,
                    })
                    ->sortable(),
                Tables\Columns\ViewColumn::make('aksi')
                    ->label('Aksi')
                    ->view('filament.tables.columns.tahanan-aksi')
                    ->alignEnd(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'keluar' => 'Keluar',
                    ]),
                Tables\Filters\Filter::make('keluar_7_hari')
                    ->label('Keluar kurang dari 7 hari ke depan')
                    ->query(function ($query) {
                        $today = now()->startOfDay();
                        $end = now()->startOfDay()->addDays(7)->endOfDay();

                        return $query
                            ->where('status', 'aktif')
                            ->whereBetween('tanggal_keluar', [$today->toDateString(), $end->toDateString()]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTahanans::route('/'),
            'create' => Pages\CreateTahanan::route('/create'),
            'view' => Pages\ViewTahanan::route('/{record}'),
            'edit' => Pages\EditTahanan::route('/{record}/edit'),
        ];
    }
}
