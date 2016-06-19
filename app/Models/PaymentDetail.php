<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class PaymentDetail extends Model
{
	protected $table = 'payment_details';

    public function paymentDetails()
    {
        return $this->hasOne('App\Models\Payment', 'id');
    }

    public function paymentMethod()
    {
        return $this->hasMany('App\Models\Banking', 'id', 'payment_type');
    }

}
