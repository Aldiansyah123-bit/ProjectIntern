<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable =[
        'name', 'type', 'latitude', 'longitude', 'country_id',
    ];
}
