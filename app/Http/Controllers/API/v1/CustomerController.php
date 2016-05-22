<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use App\Models\Customer;
use Redirect;
use View;
use Response;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
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
    protected function showAll()
    {
        $users = User::with('customer')->where('user_type', 4)->orWhere('user_type', 3)->get();
        $returnArray = array('result' => true);
        $returnArray = array_add($returnArray, 'data' , $users);
        return Response::json($returnArray );
    }

    protected function createUser(Request $request) {
        //INITIALIZATION
        $input = $request->all();

        $email          = $input['email'];
        // $password       = $input['password'];//Hash::make('pw1234'),
        $username       = $input['username'];
        $accessType     = $input['accessType'];

        $user = new User;
        $user->email   = $email;        
        $user->password   = bcrypt('pw1234');
        $user->username   = $username;
        $user->user_type   = $accessType;   
        $user->save();

        if($accessType == 4){
            $customer = new Customer;
            $customer->user_id = $user->id;
            $customer->lastname = $input['lastname'];
            $customer->firstname = $input['firstname'];
            $customer->middlename = $input['middlename'];
            $customer->address1 = $input['address'];
            $customer->save();
        }
        


        return Response::json(array('result' => true ,'message' => 'succesfully  saved' ) );

    }


    protected function updateUser(Request $request) {
        //INITIALIZATION
        $input = $request->all();

        $email          = $input['email'];
        $username       = $input['username'];
        $accessType     = $input['accessType'];

        try {
            $user = User::find($input['id']);
            $user->email   = $email;        
            $user->username   = $username;
            $user->user_type   = $accessType;   
            $user->save();

            if($accessType == 4){
                $customer = Customer::where('user_id', $input['id'])->get()->first();
                if ($customer != null)
                {
                    $customer->lastname = $input['lastname'];
                    $customer->firstname = $input['firstname'];
                    $customer->middlename = $input['middlename'];
                    $customer->address1 = $input['address'];
                    $customer->save();
                }
                else{
                    $customer = new Customer;
                    $customer->user_id = $user->id;
                    $customer->lastname = $input['lastname'];
                    $customer->firstname = $input['firstname'];
                    $customer->middlename = $input['middlename'];
                    $customer->address1 = $input['address'];
                    $customer->save();
                }
                
            }

            return Response::json(array('result' => true ,'message' => 'User Succesfully Saved!' ) );
        } catch (Exception $e) {
            return Response::json(array('result' => false ,'message' => 'Error Saving User! Contact System Admin' ) );
        }
        
    }


    protected function deleteUser(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $user = User::find($id);

        if($user->accessType == 4){
            $customer = Customer::find($id);
            $customer = Customer::where('user_id', $id);
        }
        
        try {
            $user->delete();
            if($user->accessType == 4){
                $customer->delete();
            }
            return Response::json( array('result' => true ,'message' => 'User Succesfully Deleted!' ) );

        } catch (Exception $e) {
            
        }

    }


}
