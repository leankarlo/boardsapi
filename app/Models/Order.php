<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Order extends Model
{

    protected $table = 'orders';

    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetail', 'Order_id');
    }

    public function customer()
    {
        return $this->hasMany('App\Models\Customer', 'customer_id');
    }

    public function payment()
    {
        return $this->hasOne('App\Models\Payment', 'order_id');
    }

}
