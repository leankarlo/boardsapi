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

Route::group(['middleware' => ['web']], function () {
    //
});

Route::get('/testconnection', 'API\v1\APIRequestController@TestConnection');


/* USERS */
	Route::group(array('prefix'=>'users'), function(){
		Route::get('showall', 'API\v1\UserController@showAll');
	
		Route::post('login', 'API\v1\UserController@login');
	
		Route::get('logout', 'API\v1\UserController@logout');
	});
/* END USERS */

/* PRODUCTS */
	Route::get('/products/stock/showall', 'API\v1\ProductInventoryController@ProductInventory_GetAll');
/* END PRODUCTS */