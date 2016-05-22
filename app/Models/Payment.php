<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Payment extends Model
{

	protected $table = 'payments';

    public function order()
    {
        return $this->hasOne('App\Models\Order', 'id', 'order_id');
    }

    public function paymentDetails()
    {
        return $this->hasMany('App\Models\PaymentDetails', 'order_id');
    }

}
