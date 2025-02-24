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
                ->options(Province::all()->pluck('name', 'id'))
                ->reactive()
                ->required()
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
                ->required()
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
                ->required()
                ->afterStateUpdated(function ($set, $state) {
                    $set('village_id', null);
                }),
            Forms\Components\Select::make('village_id')
                ->label('Kelurahan/Desa')
                ->options(function ($get) {
                    return Village::where('district_id', $get('district_id'))->pluck('name', 'id');
                })
                ->reactive()
                ->required(),
            Forms\Components\TextInput::make('school')
                ->label('Asal Sekolah')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('year_graduation')
                ->options([
                    '2025' => '2025',
                    '2024' => '2024',
                    '2023' => '2023',
                    '2022' => '2022',
                ])
                ->label('Tahun Lulus')
                ->required(),

            Forms\Components\TextInput::make('achievement')
                ->label('Prestasi')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('rangking')
                ->label('Rangking Terkahir')
                ->required()
                ->numeric(),
            Forms\Components\TextInput::make('phone')
                ->label('No. HP/WA')
                ->tel()
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('program')
                ->label('Program Beasiswa')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('information')
                ->label('Sumber Informasi')
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
        $this->form->validate($validatedData);
        \App\Models\StudentResponse::create([
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
