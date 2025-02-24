<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResponseResource\Pages;
use App\Filament\Resources\StudentResponseResource\RelationManagers;
use App\Models\StudentResponse;
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

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bornplace')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('birthdate')
                    ->required(),
                Forms\Components\TextInput::make('province_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('district_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('subdistrict_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('village_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('school')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('year_graduation')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('achievement')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('rangking')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('program')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('information')
                    ->required()
                    ->maxLength(255),
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
                Tables\Columns\TextColumn::make('district_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subdistrict_id')
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
