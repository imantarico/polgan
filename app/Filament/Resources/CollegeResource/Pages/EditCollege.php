<?php

namespace App\Filament\Resources\CollegeResource\Pages;

use App\Filament\Resources\CollegeResource;
use Filament\Resources\Pages\EditRecord;

class EditCollege extends EditRecord
{

    protected static string $resource = CollegeResource::class;
    protected static bool $hasBreadcrumbs = false;
    protected static ?string $title = 'Identitas PT';
}
