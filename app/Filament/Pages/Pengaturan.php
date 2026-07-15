<?php

namespace App\Filament\Pages;

use App\Models\Pengaturan as PengaturanModel;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class Pengaturan extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $view = 'filament.pages.pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan';

    protected static ?string $title = 'Pengaturan Kop Surat & Penanggung Jawab';

    protected static ?int $navigationSort = 6;
    public static function shouldRegisterNavigation(): bool
{
    return false;
}

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(PengaturanModel::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Kop Surat')
                    ->schema([
                        TextInput::make('nama_instansi')
                            ->label('Nama Instansi')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('alamat_instansi')
                            ->label('Alamat Instansi')
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('telepon_instansi')
                            ->label('Telepon Instansi')
                            ->maxLength(255),
                    ])
                    ->columns(2),
                Section::make('Penanggung Jawab Laporan')
                    ->description('Nama dan jabatan ini dicetak sebagai tanda tangan pada laporan PDF.')
                    ->schema([
                        TextInput::make('nama_penanggung_jawab')
                            ->label('Nama')
                            ->maxLength(255),
                        TextInput::make('pangkat_nrp_penanggung_jawab')
                            ->label('Pangkat / NRP')
                            ->maxLength(255),
                        TextInput::make('jabatan_penanggung_jawab')
                            ->label('Jabatan')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        PengaturanModel::current()->update($this->form->getState());

        Notification::make()
            ->title('Pengaturan tersimpan')
            ->success()
            ->send();
    }
}
