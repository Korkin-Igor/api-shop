<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['id', 'cart_id', 'product_id'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
