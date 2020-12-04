<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BookCategory extends Pivot
{
    //
    protected $table="book_category";
    protected $fillable=[
        'book_id',
        'category_id',
    ];
    
    public function book(){
        return $this->belongsTo('App\Book');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }
}
