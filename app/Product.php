<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'umkm_id', 'name', 'description', 'price', 'stok', 'img',
    ];

    public function umkm()
    {
        return $this->belongsTo('App\Umkm');
    }
}
