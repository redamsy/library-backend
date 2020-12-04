<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable=[
        'publisher_id',
        'serie_id',
        'language_id',
        'title',
        'description',
        'publishDate',
        'price',
        'chapters',
        'pages',
        'isProhibited',
        'imageName',
        'pdfName'
    ];

    public function publisher(){
        return $this->belongsTo('App\Publisher');
    }

    public function serie(){
        return $this->belongsTo('App\Serie');
    }

    
    public function language(){
        return $this->belongsTo('App\Language');
    }

    public function authors(){
        return $this->belongsToMany('App\Author','book_author');
    }

    public function categories(){
        return $this->belongsToMany('App\Category','book_category');
    }

    public function clients(){
        return $this->belongsToMany('App\Client','book_client');
    }
}
