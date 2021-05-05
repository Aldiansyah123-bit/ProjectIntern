<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'umkm_id', 'bumdes_id', 'is_checkout',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function umkm()
    {
        return $this->belongsTo('App\Umkm');
    }

    public function bumdes()
    {
        return $this->belongsTo('App\Bumdese');
    }

    public function cartdetails()
    {
        return $this->hasMany('App\Cartdetail');
    }
}
