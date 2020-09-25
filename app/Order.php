<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'user_id', 'total_amount_in_dollars', 'total_amount_in_euros', 'item_count', 'order_id', 'zip_code', 'shipping_address', 'shipping_fees', 'phone', 'full_name',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
