<?php

namespace App\Http\Controllers\API\v1;

use DB;
use App\Models\Product;
use App\Models\ProductStock;
use Redirect;
use View;
use Response;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductInventoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Users Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the Images functions
    | 1. Upload
    | 2. Edit
    | 3. Delete
    | 4. Activate
    | 5. Deactivate
    | 6. Validation
    |
    */

    // USER DISPLAYS
    protected function ProductInventory_GetAll()
    {
        $result = ProductStock::select(DB::raw('product_id, count(product_id) AS NumberOfProducts'))
                     ->groupBy('product_id')
                     ->with('product')
                     ->get();
        // $productInventory = array_add(array('products' => $result), 'result' , true);
        $productInventory = array('result' => true);
        $productInventory = array_add($productInventory, 'data' , $result);
        return Response::json( $productInventory  );
    }



}
