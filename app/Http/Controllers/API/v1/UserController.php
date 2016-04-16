<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use Redirect;
use View;
use Response;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
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
        $users = User::all()->first();
        $users = array_add($users, 'result' , true);
        return Response::json(array('data' => $users ) );
    }

    protected function login(Request $request)
    {
        
        //INITIALIZATION
        $input = $request->all();
        
        $email = $input['email'];
        $password = $input['password'];

        // PARAMETERS FOR AUTHENTICATION
        $userdata = array(
            'email'     => $input['email'],
            'password'  => $input['password'],
        );

        // AUTHENTICATE USER
        if (Auth::attempt($userdata) == true) 
        {
            $user = User::find(Auth::user()->id)->first();
            $user = array_add($user, 'result' , true);
            $user = array_add($user, 'message' , 'succesfully signed in');
            return Response::json(array('data' => $user ) );
        }
        else{
            Auth::logout();
            return Response::json(array('data' => array('result' => false ,'message' => 'incorrect email / password' )) );
        }

    }

    protected function logout(){
        Auth::logout();
        return Response::json(array('data' => array('result' => true , 'message' => 'succesfully signed out' ) ));
    }

    protected function getUserData($id)
    {
        $user = User::find($id);
        
        if ($user->isEmpty()){
            return Response::json(array('result' => 'true' ,'data' => $user ) );
        }else{
            return Response::json(array('result' => 'false' ) );
        }
    }

}
