<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'umkm_id', 'bumdes_id', 'invoice_number', 'address', 'total_price', 'discount', 'voucher', 'noted', 'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function umkm()
    {
        return $this->hasMany('App\Umkm');
    }

    public function bumdes()
    {
        return $this->hasMany('App\Bumdese');
    }
}
