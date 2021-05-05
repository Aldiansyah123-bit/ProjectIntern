<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 'umkm_id', 'bumdes_id', 'invoice_number', 'address', 'total_price', 'discount', 'voucher', 'noted', 'status','created_at', '	updated_at'
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


    public function transactiondetails()
    {
        return $this->hasMany('App\TransactionDetail');
    }
}
