<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Banking;
use App\Models\ProductStock;
use App\Models\Product;
use Redirect;
use View;
use Response;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleController extends Controller
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

    protected function SalesInformation_Range(Request $request) {

        $input = $request->all();

        $from = $input['from'];
        $to = $input['to'];

        // if($from == $to){
        //     $sales = Order::where('created_at', $to)->get();
        // }
        // else{
            $end_date = date('Y-m-d',date(strtotime("+1 day", strtotime($to))));
            $sales = Order::with('customer.user')->whereBetween('created_at', [$from, $end_date])->get();
        // }

        if(count($sales) == 0){
            return Response::json(array('result' => false, 'message' => 'no sales yet on selected dates.' ) );
        }else{
            return Response::json(array('result' => true, 'data' => $sales, 'message' => 'succesfully loaded the sales.' ) );
        }
        

        // return Response::json(array('result' => true, 'message' => 'succesfully loaded the sales' ) );

    }

    protected function OrderDetails_Get(Request $request) {

        $input = $request->all();

        $orderID = $input['order_id'];

        $saleDetails = OrderDetail::where('order_id', $orderID)->get();

        

        return Response::json(array('result' => true, 'data' => $saleDetails, 'message' => 'succesfully loaded the sales' ) );

        // return Response::json(array('result' => true, 'message' => 'succesfully loaded the sales' ) );

    }

    protected function PaymentDetails_Get(Request $request) {

        $input = $request->all();

        $orderID = $input['order_id'];

        $saleDetails = PaymentDetail::where('order_id', $orderID)->get();

        

        return Response::json(array('result' => true, 'data' => $saleDetails, 'message' => 'succesfully loaded the sales' ) );

        // return Response::json(array('result' => true, 'message' => 'succesfully loaded the sales' ) );

    }

    protected function PaymentDetails_Delete(Request $request) {

        $input = $request->all();

        $orderID = $input['order_id'];

        $affectedRows = PaymentDetail::where('order_id', $orderID)->delete();

        

        return Response::json(array('result' => true, 'data' => array('rows affected' => $affectedRows), 'message' => 'succesfully loaded the sales' ) );

        // return Response::json(array('result' => true, 'message' => 'succesfully loaded the sales' ) );

    }


}
