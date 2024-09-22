<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCatalog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'file'
    ];
}
