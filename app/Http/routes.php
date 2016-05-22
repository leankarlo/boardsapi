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

		Route::group(array('prefix'=>'stock'), function(){

			Route::get('/showall', 'API\v1\ProductInventoryController@ProductInventory_GetAll');

			Route::get('/serialcode', 'API\v1\ProductInventoryController@ProductStockSerialNumber_Get');

			Route::get('/add_serial_required', 'API\v1\ProductInventoryController@ProductStock_Add_SerialCodeRquired');

			Route::get('/add_no_serial', 'API\v1\ProductInventoryController@ProductStock_Add');

		});

		Route::group(array('prefix'=>'type'), function(){

			Route::get('/all', 'API\v1\ProductInventoryController@ProductType_GetAll');

			Route::get('/create', 'API\v1\ProductInventoryController@ProductType_Create');

		});

		Route::get('/create', 'API\v1\ProductInventoryController@Product_Create');

		Route::get('/update', 'API\v1\ProductInventoryController@Product_edit');

		Route::get('/showall', 'API\v1\ProductInventoryController@Product_GetAll');

	});
	
/* END PRODUCTS */

/* BANKING */

	Route::group(array('prefix'=>'banking'), function(){

		Route::get('/showall', 'API\v1\BankingController@Banking_GetAll');

		Route::get('/create', 'API\v1\BankingController@BankingCreate');

		Route::get('/update', 'API\v1\BankingController@BankingUpdate');

	});
/* END BANKING */


/* Customer */
	Route::group(array('prefix'=>'customers'), function(){
		
		Route::get('/showall', 'API\v1\CustomerController@showAll');

		Route::post('create', 'API\v1\CustomerController@createUser');

		Route::post('update', 'API\v1\CustomerController@updateUser');

		Route::get('delete', 'API\v1\CustomerController@deleteUser');

	});
/* End Customer */

/* order */
	Route::group(array('prefix'=>'order'), function(){

		Route::post('/new', 'API\v1\CheckOutController@createOrder');

		Route::post('/details/new', 'API\v1\CheckOutController@createOrderDetails');

	});
/* END order */

/* payment */
	Route::group(array('prefix'=>'payment'), function(){

		Route::get('/create', 'API\v1\CheckOutController@createPayment');

		Route::post('/details/new', 'API\v1\CheckOutController@createPaymentDetails');

		Route::post('/ispayed_status/update', 'API\v1\CheckOutController@updatePaymentSatus');

	});
/* END payment */