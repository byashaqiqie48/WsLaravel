<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent;

class Book extends Model
{
    /** 
    * @var array
    */
    
    protected $table ='books';

    protected $fillable = ['title', 'writer', 'summary', 'price', 'photo', 'id_jenis'];

    public function isbn()
    {
        return $this->hasOne('App\Isbn','id_isbn');
    }

    public function jenis()
    {
        return $this->belongsTo('App\Jenis','id_jenis');
    }

}
