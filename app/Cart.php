<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'name', 'price', 'photo', 'quantity', 'product_id', 'user_id',
    ];
}
