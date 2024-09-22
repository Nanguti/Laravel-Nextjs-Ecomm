<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionalCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'discount'
    ];
}
