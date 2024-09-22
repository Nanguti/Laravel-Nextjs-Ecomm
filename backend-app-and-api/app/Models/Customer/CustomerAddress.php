<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country'
    ];

    public function user()
    {
        return $this->belongsTo(Customer::class);
    }
}
