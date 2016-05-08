<?php

namespace App\Http\Controllers\API\v1;

use DB;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ProductType;
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
                     ->with('product.productType')
                     ->get();

        $productInventory = array('result' => true);
        $productInventory = array_add($productInventory, 'data' , $result);
        return Response::json( $productInventory  );
    }

    protected function ProductStockSerialNumber_Get(Request $request) {
        //INITIALIZATION
        $input = $request->all();

        $serialNumber = $input['serialnumber'];
        $productID = $input['productid'];

        $result = ProductStock::where('serial_number','=', $serialNumber)
        ->where('product_id', '=', $productID)
        ->get();

        // return Response::json( $result->count() );

        if ($result->count() <= 0){
            $productSerial = array('result' => false, 'message' => 'invalid serial number');
            // $productSerial = array_add($productSerial, 'data' , $result);
            return Response::json( $productSerial  );
        }
        else{
            $productSerial = array('result' => true);
            $productSerial = array_add($productSerial, 'data' , $result);
            return Response::json( $productSerial  );
        }

    }

    protected function Product_Create(Request $request)
    {
        //INITIALIZATION
        $input = $request->all();

        $product = new Product;
        $product->name = $input['name'];
        $product->model = $input['model'];
        $product->type = $input['type'];
        $product->isSerialCodeRequired = $input['isSerialCodeRequired'];

        try{
            $product->save();
            $return = array('result' => true, 'message' => 'New Product has been Added!');
            return Response::json( $return  );

        }catch(Exception $e){
            $return = array('result' => false, 'message' => 'Error on saving please contact admin!');
            return Response::json( $return  );
        }
        
    }

    protected function ProductType_Create(Request $request)
    {
        //INITIALIZATION
        $input = $request->all();

        $productTypeName = $input['name'];
        $productType = new ProductType;
        $productType->name = $productTypeName;
        try{
            $productType->save();
            $return = array('result' => true, 'message' => 'New Product Type Added!');
            return Response::json( $return  );

        }catch(Exception $e){
            $return = array('result' => false, 'message' => 'Error on saving please contact admin!');
            return Response::json( $return  );
        }
        
    }

    protected function ProductType_GetAll(){
        $result = ProductType::all();
        $productInventory = array('result' => true);
        $productInventory = array_add($productInventory, 'data' , $result);
        return Response::json( $productInventory  );
    }

    protected function ProductStock_Add(Request $request)
    {
        //INITIALIZATION
        $input = $request->all();

        $product = new Product;
        $product->name = $input['name'];
        $product->model = $input['model'];
        $product->type = $input['type'];
        $product->isSerialCodeRequired = $input['isSerialCodeRequired'];

        try{
            $product->save();
            $return = array('result' => true, 'message' => 'New Product has been Added!');
            return Response::json( $return  );

        }catch(Exception $e){
            $return = array('result' => false, 'message' => 'Error on saving please contact admin!');
            return Response::json( $return  );
        }
        
    }

}
