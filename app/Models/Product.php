<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Product extends Model
{

    protected $table = 'products';

    public function productTypeDetails()
    {
        return $this->hasMany('App\Models\ProductTypeDetail', 'product_id');
    }

    public function productStocks()
    {
        return $this->hasMany('App\Models\ProductStock', 'product_id');
    }

}
