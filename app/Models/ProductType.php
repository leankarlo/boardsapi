<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class ProductType extends Model
{

    protected $table = 'product_types';

    public function productTypeDetails()
	{
		return $this->belongsTo('App\Models\ProductCategory', 'category_id');
	}

	// public function product()
	// {
	// 	return $this->belongsTo('App\Models\Product', 'type');
	// }

}
