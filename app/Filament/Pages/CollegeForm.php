<?php

namespace App\Filament\Pages;

use App\Models\College;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class CollegeForm extends Page
{
    use Forms\Concerns\InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap'; // Ikon menu
    protected static ?string $navigationLabel = 'College'; // Nama di navigasi
    protected static ?string $navigationGroup = 'Setting'; // Grup di navigasi

    protected static ?string $title = 'College Form';
    protected static string $view = 'filament.pages.college-form';
    public ?College $college = null;
    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }
    public function mount(): void
    {
        $this->college = College::first();
        // dd($this->college->toArray());
        if ($this->college) {
            $this->form->fill($this->college->toArray()); // Mengisi form dengan data
        }
    }


    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Nama Perguruan Tinggi')
                ->statePath('college.name')
                ->required(),

            Forms\Components\TextInput::make('address')
                ->label('Alamat')
                ->required(),

            Forms\Components\TextInput::make('telephone')
                ->label('Telepon')
                ->tel()
                ->required(),

            Forms\Components\TextInput::make('fax')
                ->label('Fax')
                ->maxLength(255),

            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),

            Forms\Components\TextInput::make('postal_code')
                ->label('Kode Pos')
                ->required(),

            Forms\Components\TextInput::make('website')
                ->label('Website')
                ->required(),

            Forms\Components\FileUpload::make('logo')
                ->label('Logo')
                ->directory('images/college')
                ->image()
                ->visibility('private')
                ->previewable(true),
        ];
    }

    public function submit(): void
    {
        $validatedData = $this->form->getState();
        $this->form->validate();

        $college = College::firstOrNew();
        $college->fill($validatedData);
        $college->save();

        Notification::make()
            ->title('Berhasil!')
            ->body('Data Perguruan Tinggi telah diperbarui.')
            ->icon('heroicon-o-check-circle')
            ->success()
            ->send();
    }
}
