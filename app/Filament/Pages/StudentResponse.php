<?php

namespace App\Filament\Pages;

use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class StudentResponse extends Page
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $title = 'Angket Siswa';
    protected static string $view = 'filament.pages.student-response';
    protected static string $layout = 'filament-panels::components.layout.simple';

    public $name, $email, $bornplace, $birthdate, $nik, $province_id, $district_id, $regency_id, $village_id, $school, $phone, $year_graduation, $achievement, $rangking, $program, $information;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nama Lengkap')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('bornplace')
                ->label('Tempat Lahir')
                ->required()
                ->maxLength(255),

            Forms\Components\DatePicker::make('birthdate')
                ->label('Tanggal Lahir')
                ->required(),

            Forms\Components\Select::make('province_id')
                ->label('Provinsi')
                ->placeholder("Silahkan Dipilih")
                ->options(Province::all()->pluck('name', 'id'))
                ->reactive()
                ->required()
                ->afterStateUpdated(fn($set) => $set('regency_id', null)),

            Forms\Components\Select::make('regency_id')
                ->label('Kabupaten')
                ->placeholder("Silahkan Dipilih")
                ->options(fn($get) => Regency::where('province_id', $get('province_id'))->pluck('name', 'id'))
                ->reactive()
                ->required()
                ->afterStateUpdated(fn($set) => $set('district_id', null)),

            Forms\Components\Select::make('district_id')
                ->label('Kecamatan')
                ->placeholder("Silahkan Dipilih")
                ->options(fn($get) => District::where('regency_id', $get('regency_id'))->pluck('name', 'id'))
                ->reactive()
                ->required()
                ->afterStateUpdated(fn($set) => $set('village_id', null)),

            Forms\Components\Select::make('village_id')
                ->label('Kelurahan/Desa')
                ->placeholder("Silahkan Dipilih")
                ->options(fn($get) => Village::where('district_id', $get('district_id'))->pluck('name', 'id'))
                ->reactive()
                ->required(),

            Forms\Components\TextInput::make('school')
                ->label('Asal Sekolah')
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('year_graduation')
                ->label('Tahun Lulus')
                ->placeholder("Silahkan Dipilih")
                ->options([
                    '2025' => '2025',
                    '2024' => '2024',
                    '2023' => '2023',
                    '2022' => '2022',
                ])
                ->required(),

            Forms\Components\TextInput::make('achievement')
                ->label('Prestasi')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('rangking')
                ->label('Rangking Terakhir')
                ->required()
                ->numeric(),

            Forms\Components\TextInput::make('phone')
                ->label('No. HP/WA')
                ->tel()
                ->required()
                ->maxLength(255),

            Forms\Components\Select::make('program')
                ->label('Program Beasiswa')
                ->placeholder("Silahkan Dipilih")
                ->options([
                    'KIP' => 'KIP',
                    'Yayasan' => 'Yayasan',
                    'Prestasi' => 'Prestasi', // Perbaikan Typo
                    'Hafizh' => 'Hafizh Quran',
                ])
                ->required(),

            Forms\Components\Select::make('information')
                ->label('Sumber Informasi')
                ->placeholder("Silahkan Dipilih")
                ->options([
                    'Brosur' => 'Brosur',
                    'Facebook' => 'Facebook',
                    'Instagram' => 'Instagram',
                    'Teman' => 'Teman',
                    'Marketing' => 'Marketing',
                ])
                ->required(),
        ];
    }

    public function submit(): void
    {
        $validatedData = $this->form->getState();
        $this->form->validate();

        \App\Models\StudentResponse::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'bornplace' => $validatedData['bornplace'],
            'birthdate' => $validatedData['birthdate'],
            'province_id' => $validatedData['province_id'],
            'regency_id' => $validatedData['regency_id'], // Tambah ini
            'district_id' => $validatedData['district_id'],
            'village_id' => $validatedData['village_id'],
            'school' => $validatedData['school'],
            'year_graduation' => $validatedData['year_graduation'],
            'achievement' => $validatedData['achievement'],
            'rangking' => $validatedData['rangking'],
            'phone' => $validatedData['phone'],
            'program' => $validatedData['program'],
            'information' => $validatedData['information'],
        ]);

        Notification::make()
            ->title('Selamat !!!')
            ->body('Data Berhasil Tersimpan')
            ->icon('heroicon-o-check-circle')
            ->success()
            ->send();

        $this->redirect('/angket');
    }
}
