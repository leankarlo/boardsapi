<?php

namespace App\Http\Controllers\API\v1;

use DB;
use App\Models\Banking;
use Redirect;
use View;
use Response;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BankingController extends Controller
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
    protected function Banking_GetAll()
    {
        $result = Banking::all();

        $banking = array('result' => true);
        $banking = array_add($banking, 'data' , $result);
        return Response::json( $banking  );
    }

    protected function BankingCreate(Request $request)
    {
        $input = $request->all();

        $banking = new Banking;
        $banking->name              = $input['name'];
        $banking->banking_fee       = $input['fee'];
        $banking->chargeToCustomer  = $input['chargeToCustomer'];

        try{
            $banking->save();
            $return = array('result' => true, 'message' => 'New Banking Payment has been Added!');
            return Response::json( $return  );

        }catch(Exception $e){
            $return = array('result' => false, 'message' => 'Error on saving please contact admin!');
            return Response::json( $return  );
        }

    }

    protected function BankingUpdate(Request $request)
    {
        $input  = $request->all();
        $id     = $input['id'];

        $banking = Banking::find($id);
        $banking->name              = $input['name'];
        $banking->banking_fee       = $input['fee'];
        $banking->chargeToCustomer  = $input['chargeToCustomer'];

        try{
            $banking->save();
            $return = array('result' => true, 'message' => 'Banking Payment has been Updated!');
            return Response::json( $return  );

        }catch(Exception $e){
            $return = array('result' => false, 'message' => 'Error on saving please contact admin!');
            return Response::json( $return  );
        }

    }

    
}
