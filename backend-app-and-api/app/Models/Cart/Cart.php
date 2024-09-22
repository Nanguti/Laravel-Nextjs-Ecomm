<?php

namespace App\Models\Cart;

use App\Models\Customer\Customer;
use App\Models\Order\Order;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'order_id',
        'quantity',
        'amount',
        'price',
        'status'
    ];

    public static function getAllProductFromCart()
    {
        return Cart::with('product')
            ->where('user_id', auth()->user()->id)
            ->get();
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function user()
    {
        return $this->belongsTo(Customer::class);
    }
}
