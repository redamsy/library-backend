<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{
    //
    protected $table="book_author";
    protected $fillable=[
        'book_id',
        'author_id',
    ];
    
    public function book(){
        return $this->belongsTo('App\Book');
    }

    public function author(){
        return $this->belongsTo('App\Author');
    }
}
