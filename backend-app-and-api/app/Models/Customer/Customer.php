<?php

namespace App\Models\Customer;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }
}
