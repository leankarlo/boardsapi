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

        $users = User::where('user_type', 0)->orWhere('user_type', 1)->orWhere('user_type', 2)->get();
        $returnArray = array('result' => true);
        $returnArray = array_add($returnArray, 'data' , $users);
        return Response::json($returnArray );
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
            $user = User::find(Auth::user()->id);
            return Response::json(array('result' => true, 'data' => $user, 'message' => 'succesfully signed in' ) );
        }
        else{
            Auth::logout();
            return Response::json(array('result' => false ,'message' => 'incorrect email / password' ) );
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

        return Response::json(array('result' => true ,'message' => 'User Succesfully Saved!' ) );

    }

    protected function updatePassword(Request $request){
        $input              = $request->all();

        $id                 = $input['id'];
        $currentPassword    = $input['current_password'];
        $password           = $input['password'];

        $user = User::find($id);

        if($currentPassword == $user->password){
            
            $user->password   = bcrypt($password);
            $user->save();

            return Response::json(array('result' => true ,'message' => 'Password Succesfully Saved!' ) );

        }else{
            return Response::json(array('result' => false ,'message' => 'Current passeword does not match Please Try again!!' ) );
        }

        
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

            return Response::json(array('result' => true ,'message' => 'User Succesfully Saved!' ) );
        } catch (Exception $e) {
            return Response::json(array('result' => false ,'message' => 'Error Saving User! Contact System Admin' ) );
        }
        
    }

    protected function resetPasswordUser(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        $user = User::find($id);
        try {
            $user->password   = bcrypt('pw1234');
            $user->save();
            return Response::json( array('result' => true ,'message' => 'User Password Set to Default!!' ) );

        } catch (Exception $e) {
            return Response::json( array('result' => false ,'message' => 'Error!! Contact System Admin' ) );
        }

    }

    protected function deleteUser(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];
        $user = User::find($id);
        try {
            $user->delete();
            return Response::json( array('result' => true ,'message' => 'User Succesfully Deleted!' ) );

        } catch (Exception $e) {
            
        }

    }

    protected function logout(){
        Auth::logout();
        return Response::json(array('data' => array('result' => true , 'message' => 'succesfully signed out' ) ));
    }

    protected function getUserData(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        $user = User::find($id);
        if($user != null){
            return Response::json(array('result' => true ,'data' => $user ) );
        }else{
            return Response::json(array('result' => false  ) );
        }
        
    }

}
