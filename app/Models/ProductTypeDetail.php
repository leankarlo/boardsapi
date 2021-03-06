<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class ProductTypeDetail extends Model
{

    protected $table = 'product_type_details';

    public function product()
	{
		return $this->belongsTo('App\Models\Product', 'product_id');
	}

	public function productType()
	{
		return $this->belongsTo('App\Models\ProductType', 'product_type_id');
	}

}
