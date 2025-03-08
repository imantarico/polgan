<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Setting';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('username')
                    ->required()
                    ->maxLength(255)
                    ->unique(table: User::class, column: 'username', ignoreRecord: true),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('password')
                    ->password()
                    ->maxLength(255)
                    ->nullable() // Biarkan kosong saat edit
                    ->dehydrated(fn ($state) => filled($state)), // Hanya kirim jika ada perubahan

                Forms\Components\Select::make('roles')
                    ->label('Roles')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->required(),

                Forms\Components\Toggle::make('active')
                    ->label('Aktif')
                    ->default(true), // Harus boolean, bukan string
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('username')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->separator(', ')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\ToggleColumn::make('active')->sortable(),


                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('resetPassword')


                    ->icon('heroicon-o-key')
                    ->label('Reset')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $record->update(['password' => Hash::make('password')]);
                        Notification::make()
                            ->title('Berhasil Reset Password')
                            ->body("Password user {$record->name} berhasil direset")
                            ->success()
                            ->send();
                    }),
//                Tables\Actions\Action::make('loginAs')
//                    ->label('Login As')
//                    ->color('warning')
//                    ->requiresConfirmation()
//                    ->action(function (User $record) {
//                        // Simpan ID admin sebelum login sebagai user lain
//                        session(['impersonate' => Auth::id()]);
//
//                        // Gunakan loginUsingId agar session tetap aman
//                        Auth::loginUsingId($record->id);
//
//                        Notification::make()
//                            ->title('Berhasil Login')
//                            ->body("Anda sekarang login sebagai {$record->name}")
//                            ->success()
//                            ->send();
//
//                        return redirect()->route('filament.admin.pages.dashboard');
//                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Jangan ubah jika kosong
        }
        return $data;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
