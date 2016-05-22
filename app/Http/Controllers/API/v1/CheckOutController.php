<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Banking;
use Redirect;
use View;
use Response;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckOutController extends Controller
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

    protected function createOrder(Request $request) {

        $input = $request->all();

        $order = new Order;
        $order->customer_id = $input['customer_id'];
        $order->customer_id = $input['initial_selling_price'];
        $order->customer_id = $input['discount_price'];
        $order->customer_id = $input['total_price'];
        $order->created_by = $input['created_by'];
        $order->save();

        return Response::json(array('result' => true, 'data' => array('order_id' => $order->id), 'message' => 'succesfully created an order' ) );

    }

    protected function createPayment(Request $request) {
        
        $input = $request->all();

        $payment = new Payment;
        $payment->order_id = $input['order_id'];
        $payment->save();

        return Response::json(array('result' => true, 'data' => array('payment_id' => $payment->id), 'message' => 'succesfully created a payment' ) );

    }

    protected function createOrderDetails(Request $request){
        $input = $request->all();
        $order_id = $input['order_id'];

        $orders = $input['order'];

        foreach ($orders as $order) {
            $orderDetails = new OrderDetail;
            $orderDetails->order_id         = $order_id;
            $orderDetails->product_stock_id = $order['product_stock_id'];
            $orderDetails->item_discount    = $order['item_discount'];
            $orderDetails->selling_price    = $order['total_price'];
            $orderDetails->save();
        }

        return Response::json(array('result' => true,  'message' => 'succesfully created a order details' ) );
    }

    protected function createPaymentDetails(Request $request){
        $input = $request->all();
        $order_id = $input['order_id'];

        $payments = $input['payment'];

        foreach ($payments as $payment) {
            $paymentDetails = new PaymentDetail;
            $paymentDetails->order_id       = $order_id;
            $paymentDetails->payment_type   = $payment['payment_type'];
            $paymentDetails->amount         = $payment['amount'];
            $paymentDetails->fee            = $payment['fee'];
            $paymentDetails->save();
        }

        return Response::json(array('result' => true,  'message' => 'succesfully created a payment details' ) );
    }

    protected function updatePaymentSatus(Request $request){
        $input = $request->all();
        $order_id   = $input['order_id'];
        $status     = $input['status'];

        $payment = Payment::where('order_id', $order_id)->get();
        $payment->isPayed = $status;
        $payment->save();

        return Response::json(array('result' => true,  'message' => 'succesfully updated a payment isPayed status' ) );
    }

}
