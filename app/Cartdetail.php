<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cartdetail extends Model
{
    protected $fillable = [
        'cart_id', 'product_id', 'amount', 'flag',
    ];

    public function cart()
    {
        return $this->belongsTo('App\Cart');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
