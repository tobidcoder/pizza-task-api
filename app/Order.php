<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'user_id', 'total_amount_in_dollars', 'total_amount_in_euros',
    ];
}
