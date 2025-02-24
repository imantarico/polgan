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
    public $name, $email, $bornplace, $birthdate, $nik, $province_id, $district_id, $regency_id, $village_id, $school, $phone;
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('Nama Lengkap')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('Email')
                ->email()
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('Tempat Lahir')
                ->required()
                ->maxLength(255),
            Forms\Components\DatePicker::make('Tanggal Lahirr')
                ->required(),
            Forms\Components\Select::make('province_id')
                ->label('Provinsi')
                ->options(Province::all()->pluck('name', 'id'))
                ->reactive()
                ->afterStateUpdated(function ($set, $state) {
                    $set('district_id', null);
                    $set('subdistrict_id', null);
                }),

            Forms\Components\Select::make('regency_id')
                ->label('Kabupaten')
                ->options(function ($get) {
                    return Regency::where('province_id', $get('province_id'))->pluck('name', 'id');
                })
                ->reactive()
                ->afterStateUpdated(function ($set, $state) {
                    $set('district_id', null);
                    $set('village_id', null);
                }),
            Forms\Components\Select::make('district_id')
                ->label('Kecamatan')
                ->options(function ($get) {
                    return District::where('regency_id', $get('regency_id'))->pluck('name', 'id');
                })
                ->reactive()
                ->afterStateUpdated(function ($set, $state) {
                    $set('village_id', null);
                }),
            Forms\Components\Select::make('village_id')
                ->label('Kelurahan/Desa')
                ->options(function ($get) {
                    return Village::where('district_id', $get('district_id'))->pluck('name', 'id');
                })
                ->reactive(),
            Forms\Components\TextInput::make('Asal Sekolah')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('Tahun Tamat')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('Prestasi')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('Rangking Terkahir')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('No.HP/WhatsApp')
                ->tel()
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('Program Beasiswa')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('Mendapatkan Informasi')
                ->required()
                ->maxLength(255),
        ];
    }

    public function submit(): void
    {
        $validatedData = $this->form->getState();
        $this->form->validate($validatedData);
        \App\Models\Participant::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'bornplace' => $validatedData['bornplace'],
            'birthdate' => $validatedData['birthdate'],
            'province_id' => $validatedData['province_id'],
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
        session()->flash('message', 'Data berhasil disimpan.');
        //make message
        Notification::make()
            ->title('Selamat !!!')
            ->body('Data Berhasil Tersimpan')
            ->icon('heroicon-o-check-circle')
            ->success()
            ->send();
        $this->redirect('/angket');
    }

}
