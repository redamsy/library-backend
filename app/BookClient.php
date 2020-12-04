<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookClient extends Model
{
    //
    protected $table="book_client";
    protected $fillable=[
        'book_id',
        'client_id',
    ];
    
    public function book(){
        return $this->belongsTo('App\Book');
    }

    public function client(){
        return $this->belongsTo('App\Client');
    }
}
