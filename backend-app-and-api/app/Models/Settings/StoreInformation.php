<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreInformation extends Model
{
    use HasFactory;
    protected $fillable = [
        'short_description',
        'description',
        'photo',
        'address',
        'phone',
        'email',
        'logo'
    ];
}
