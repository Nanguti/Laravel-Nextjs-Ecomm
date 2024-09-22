<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'status',
        'photo',
        'brand_url',
        'support_url'
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public static function getProductByBrand($slug)
    {

        return Brand::with('products')->where('slug', $slug)->first();
    }
}
