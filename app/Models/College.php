<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'logo' => 'array',
    ];

    protected function getFormModel(): string
    {
    return College::class;
    }
    protected function getFormStatePath(): ?string
    {
        return 'college';
    }
}
