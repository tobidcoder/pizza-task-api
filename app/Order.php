<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'user_id', 'total_amount_in_dollars', 'total_amount_in_euros', 'item_count', 'order_id', 'shipping_address', 'shipping_fees', 'phone_number',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
