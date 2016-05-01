<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/



Route::get('/testconnection', 'API\v1\APIRequestController@TestConnection');


/* USERS */
	Route::group(array('prefix'=>'users'), function(){

		Route::get('/get', 'API\v1\UserController@getUserData');

		Route::get('/reset_password', 'API\v1\UserController@resetPasswordUser');
		
		Route::get('/showall', 'API\v1\UserController@showAll');
	
		Route::post('login', 'API\v1\UserController@login');
	
		Route::get('logout', 'API\v1\UserController@logout');

		Route::post('create', 'API\v1\UserController@createUser');

		Route::post('update', 'API\v1\UserController@updateUser');

		Route::get('delete', 'API\v1\UserController@deleteUser');

		Route::post('change_password', 'API\v1\UserController@updateUserPassword');

	});
/* END USERS */

/* PRODUCTS */

	Route::group(array('prefix'=>'products'), function(){

		Route::get('/stock/showall', 'API\v1\ProductInventoryController@ProductInventory_GetAll');

		Route::get('/stock/serialcode', 'API\v1\ProductInventoryController@ProductStockSerialNumber_Get');

	});
	
/* END PRODUCTS */