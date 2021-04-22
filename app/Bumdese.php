<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bumdese extends Model
{
    protected $fillable =[
        'name', 'region_id', 'address', 'latitude', 'longitude', 'phone', 'avatar', 'background',
    ];

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

}
