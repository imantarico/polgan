<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResponseResource\Pages;
use App\Filament\Resources\StudentResponseResource\RelationManagers;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\StudentResponse;
use App\Models\Village;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResponseResource extends Resource
{
    protected static ?string $model = StudentResponse::class;
    protected static ?string $navigationGroup = 'PMB';
    protected static ?string $navigationLabel = 'Angket';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bornplace')
                    ->searchable(),
                Tables\Columns\TextColumn::make('birthdate')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('province_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('regency_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('district_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('village_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('school')
                    ->searchable(),
                Tables\Columns\TextColumn::make('year_graduation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('achievement')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rangking')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('program')
                    ->searchable(),
                Tables\Columns\TextColumn::make('information')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStudentResponses::route('/'),
            'create' => Pages\CreateStudentResponse::route('/create'),
            'edit' => Pages\EditStudentResponse::route('/{record}/edit'),
        ];
    }
}
