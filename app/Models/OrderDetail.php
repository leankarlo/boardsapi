<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class OrderDetail extends Model
{

    // protected $table = 'order';

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id');
    }

    public function customer()
    {
    	return $this->hasMany('App\Models\Customer', 'customer_id');
    }

    // public function productStocks()
    // {
    //     return $this->hasMany('App\Models\ProductStock', 'product_id');
    // }

}
