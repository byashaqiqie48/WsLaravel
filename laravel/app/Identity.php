<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Identity extends Model
{
    protected $table = 'identity';
    protected $fillable = ['nama_identity'];

    public function books()
    {
        return $this->belongsToMany('App\Book','identity_book','id_identity','id_book');
    }
}
