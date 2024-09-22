<?php

namespace App\Models\Product;

use App\Models\Customer\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rate',
        'review',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->hasOne(Customer::class, 'id', 'user_id');
    }

    public static function getAllReview()
    {
        return Review::with('user_info')->paginate(10);
    }
    public static function getAllUserReview()
    {
        return Review::where('user_id', auth()->user()->id)
            ->with('user_info')->paginate(10);
    }
}
