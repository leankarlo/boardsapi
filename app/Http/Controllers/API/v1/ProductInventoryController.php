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
        $result = ProductStock::where('isAvailable',1)->where('isRemovedRemark',0)
                     ->select(DB::raw('product_id, count(product_id) AS NumberOfProducts'))
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
        ->where('isRemovedRemark',0)
        ->get()->first();

        if ($result == null){
            $productSerial = array('result' => false, 'message' => 'invalid serial number');
            return Response::json( $productSerial  );
        }
        else{
            $productSerial = array('result' => true, 'data' => $result );
            return Response::json( $productSerial  );
        }

    }


    protected function Product_GetAll()
    {
        $result = Product::with('productType')->get();

        $product = array('result' => true);
        $product = array_add($product, 'data' , $result);
        return Response::json( $product );
    }


    protected function Product_Create(Request $request)
    {
        //INITIALIZATION
        $input = $request->all();

        $product = new Product;
        $product->name = $input['name'];
        $product->model = $input['model'];
        $product->type = $input['type'];
        $product->price = $input['price'];
        $product->isSerialCodeRequired = $input['isSerialCodeRequired'];
        $product->isIMEIRequired = $input['isIMEIRequired'];

        try{
            $product->save();
            $return = array('result' => true, 'message' => 'New Product has been Added!');
            return Response::json( $return  );

        }catch(Exception $e){
            $return = array('result' => false, 'message' => 'Error on saving please contact admin!');
            return Response::json( $return  );
        }
        
    }

    protected function Product_Edit(Request $request)
    {
        //INITIALIZATION
        $input = $request->all();

        $product        = Product::find($input['id']);
        $product->name  = $input['name'];
        $product->model = $input['model'];
        $product->type  = $input['type'];
        $product->price = $input['price'];
        $product->isSerialCodeRequired = $input['isSerialCodeRequired'];
        $product->isIMEIRequired = $input['isIMEIRequired'];

        try{
            $product->save();
            $return = array('result' => true, 'message' => 'Product has been Updated!');
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

    protected function ProductStock_Add_SerialCodeRquired(Request $request)
    {
        //INITIALIZATION
        $input = $request->all();
        $imei = '';
        if( isset($input['imei'])){
            $imei = $input['imei'];
        }

        $productStock = new ProductStock;
        $productStock->product_id = $input['product_id'];
        $productStock->serial_number = $input['serial_number'];
        $productStock->imei = $imei;
        $productStock->isAvailable = 1;

        try{
            $productStock->save();
            $return = array('result' => true, 'message' => 'New Product has been Added!');
            return Response::json( $return  );

        }catch(Exception $e){
            $return = array('result' => false, 'message' => 'Error on saving please contact admin!');
            return Response::json( $return  );
        }
        
    }

    protected function ProductStock_Add(Request $request)
    {
        //INITIALIZATION
        $input = $request->all();

        $quantity = $input['quantity'];
        $count = 0;

        for($i = 0;$i < $quantity; $i++){
            
            $productStock = new ProductStock;
            $productStock->product_id = $input['product_id'];
            $productStock->isAvailable = 1;
            $productStock->save();
            $count++;
        }

        $return = array('result' => true, 'message' => $i. ' New Product has been Added!');
        return Response::json( $return  );   
    }

    protected function ProductStock_PullOut(Request $request){
        $input = $request->all();

        // 0 = not removed default value
        // 1 = Defect
        // 2 = Error on Input

        try{

            $productID = $input['product_id'];
            $productDeleteRemark = $input['deleteremarkid'];
            $quantity = $input['quantity'];
            $count = 0;
    
            for($i = 0;$i < $quantity; $i++){
                $productStock = ProductStock::where('product_id', $productID)->where('isAvailable', 1)->get()->first();
                $productStock->isRemovedRemark = $productDeleteRemark;
                $productStock->isAvailable      = 0;
                $productStock->save();
                $count++;
            }
            
            
    
            $return = array('result' => true, 'message' => $i. 'Product Stock has been Removed!');
            return Response::json( $return  );   

        }catch(Exception $e){
            $return = array('result' => false, 'message' => $i. 'Error on Removing Product. Please Contact Admin!');
            return Response::json( $return  );
        }

        
    }

    protected function ProductStock_PullOutSerialCode(Request $request){
        $input = $request->all();

        // 0 = not removed default value
        // 1 = Defect
        // 2 = Error on Input

        try{

            $productID = $input['product_id'];
            $productDeleteRemark = $input['deleteremarkid'];
            $serialnumber = $input['serialnumber'];
            $count = 0;
    
            $productStock = ProductStock::where('product_id', $productID)->where('serial_number', $serialnumber)->get()->first();
            $productStock->isRemovedRemark = $productDeleteRemark;
            $productStock->isAvailable      = 0;
            $productStock->save();
            
            
    
            $return = array('result' => true, 'message' => 'Product Stock has been Removed!');
            return Response::json( $return  );   

        }catch(Exception $e){
            $return = array('result' => false, 'message' => 'Error on Removing Product. Please Contact Admin!');
            return Response::json( $return  );
        }

    }

    protected function ProductStock_GetProduct(Request $request){

        $input = $request->all();
        $productID = $input['product_id'];

        $product = ProductStock::where('product_id', $productID)->get();

        $productStock = array('result' => true);
        $productStock = array_add($productStock, 'data' , $product);
        return Response::json( $productStock  );

    }

    protected function ProductStock_Remove(Request $request){
        $input = $request->all();
        $ID = $input['productstock_id'];

        $stock = ProductStock::find($ID);
        $stock->delete();

        $return = array('result' => true, 'message' => 'Stock Product has been removed');
        return Response::json( $return  );
    }

}
