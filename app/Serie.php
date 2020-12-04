<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    //
    protected $fillable=[
        'name',
    ];

    public function books(){
        return $this->hasMany('App\Book');
    }
}
