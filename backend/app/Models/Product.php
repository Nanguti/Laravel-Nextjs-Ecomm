<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','category_id', 'description', 'price', 'stock'];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function review(){
        return $this->belongsTo(Review::class);
    }
}
