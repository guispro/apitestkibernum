<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = [
        'nombre', 'descripcion', 'cantidad', 'busquedas', 'valor'
    ];

    public function histories(){
    	return $this->belongsToMany('App\History');
    }
}
