<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','role_id','bumdes_id','umkm_id','region_id','address','latitude',
        'longitude','email', 'password','last_login_at','phone','avatar'
    ];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function bumdes()
    {
        return $this->belongsTo('App\Bumdese');
    }

    public function umkm()
    {
        return $this->belongsTo('App\Umkm');
    }

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified' => 'datetime',
    ];
}
