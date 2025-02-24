<?php

namespace App\Filament\Resources\StudentResponseResource\Pages;

use App\Filament\Resources\StudentResponseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentResponses extends ListRecords
{
    protected static string $resource = StudentResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
