<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactiondetail extends Model
{
    protected $fillable = [
        'transaction_id', 'product_id', 'price', 'amount', 'flag',
    ];

    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
