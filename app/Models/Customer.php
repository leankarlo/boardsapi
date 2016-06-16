<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Customer extends Model
{

    protected $table = 'customers';

    public function user()
    {
    	return $this->hasOne('App\Models\User', 'id', 'user_id');
    }

    public function order()
    {
        return $this->belongsToMany('App\Models\Order', 'customer_id', 'user_id');
    }

}
