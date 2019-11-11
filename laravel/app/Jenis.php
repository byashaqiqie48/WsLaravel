<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
    protected $table='jenisbuku';
    protected $fillable=['jenis_buku'];
    public function books()
    {
        return $this->hasMany('App\Book','id_jenis');
    }
}
