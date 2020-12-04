<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable=[
        'id',
        'user_id',
        'phoneNumber'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
        
    public function books(){
        return $this->belongsToMany('App\Book','book_client');
    }
}
