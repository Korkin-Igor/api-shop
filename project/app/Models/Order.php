<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_id',
        'product_id'
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'updated_at'
    ];
}
