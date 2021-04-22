<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $fillable =[
        'name', 'description', 'region_id', 'address', 'latitude', 'longitude','phone', 'avatar', 'background',
    ];

    public function region()
    {
        return $this->belongsTo('App\Region');
    }
}
