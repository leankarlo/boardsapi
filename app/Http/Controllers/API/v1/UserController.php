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

        $users = User::all();
        $returnArray = array('result' => true);
        $returnArray = array_add($returnArray, 'users' , $users);
        return Response::json(array('data' => $returnArray ) );
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

        return Response::json(array('data' => array('result' => false ,'message' => 'User Succesfully Saved!' )) );

    }

    protected function updateUser(Request $request) {
        //INITIALIZATION
        $input = $request->all();

        $email          = $input['email'];
        // $password       = $input['password'];//Hash::make('pw1234'),
        $username       = $input['username'];
        $accessType     = $input['accessType'];

        try {
            $user = User::find($input['id']);
            $user->email   = $email;        
            // $user   = bcrypt($password);
            $user->username   = $username;
            $user->user_type   = $accessType;   
            $user->save();

            return Response::json(array('data' => array('result' => true ,'message' => 'User Succesfully Saved!' )) );
        } catch (Exception $e) {
            return Response::json(array('data' => array('result' => false ,'message' => 'Error Saving User! Contact System Admin' )) );
        }
        
    }

    protected function deleteUser($id)
    {
        $user = User::find($id);
        

        try {
            $user->delete();
            return Response::json(array('data' => array('result' => true ,'message' => 'User Succesfully Deleted!' )) );

        } catch (Exception $e) {
            
        }

    }

    protected function logout(){
        Auth::logout();
        return Response::json(array('data' => array('result' => true , 'message' => 'succesfully signed out' ) ));
    }

    protected function getUserData($id)
    {
        $user = User::find($id);
        if($user != null){
            return Response::json(array('result' => true ,'data' => $user ) );
        }else{
            return Response::json(array('result' => false  ) );
        }
        
    }

}
