<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
