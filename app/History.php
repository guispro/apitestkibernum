<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = [
        'producto_id', 'keyword','cantidad'
    ];

    
}
