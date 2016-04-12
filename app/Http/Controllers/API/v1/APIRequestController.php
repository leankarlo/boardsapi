<?php

namespace App\Http\Controllers\API\v1;

use App\Models\User;
use Redirect;
use View;
use Response;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIRequestController extends Controller
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
    protected function TestConnection()
    {
        return Response::json(array('data' => array('result' => true,'message' => 'API Connection Succesfull') ) );
    }



}
