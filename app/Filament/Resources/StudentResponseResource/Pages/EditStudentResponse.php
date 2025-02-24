<?php

namespace App\Filament\Resources\StudentResponseResource\Pages;

use App\Filament\Resources\StudentResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentResponse extends EditRecord
{
    protected static string $resource = StudentResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
