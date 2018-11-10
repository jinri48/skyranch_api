<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserSite;
use App\CCEOnDuty;
use App\Clarion;

use Validator;

class LoginController extends Controller
{
    //
    public function login(Request $request){ 

    	//check the username if numeric
    	if( !is_numeric($request->username) ){
    		return response()->json([
	    		'success' 			=> false,
	    		'status' 			=> 401,
	    		'message' 			=> 'Invalid Username | not numeric'
	    	]);
    	}

    	$us = UserSite::findByNumber($request->username);

    	//check if the username is not exist
    	if( is_null($us) ){
    		return response()->json([
	    		'success' 			=> false,
	    		'status' 			=> 401,
	    		'message' 			=> 'Invalid Username'
	    	]);
    	}

    	//check the password is not match 
    	if( trim($us->PW) != $request->password){
    		return response()->json([
	    		'success' 			=> false,
	    		'status' 			=> 401,
	    		'message' 			=> 'Invalid Password'
	    	]);
    	}


    	//check if on dutty
    	$c 		= new Clarion; 
    	$cce 	= new CCEOnDuty;
    	// dd($c->today());
    	if( is_null($cce->isOnDuty($request->username, $c->today() )) ){
    		return response()->json([
	    		'success' 			=> false,
	    		'status' 			=> 401,
	    		'message' 			=> 'Not on Duty!'
	    	]);
    	}

        
    	//create a new token for new login
    	$newToken = UserSite::newToken($request->username);  

    	//save the newToken
    	$us->TOKEN  = $newToken;
    	$us->save();
        
    	//if success
    	return response()->json([
    		'success' 			=> true,
    		'status' 			=> 200,
    		'message' 			=> 'success',
    		'name' 				=> $us->NAME,
    		'token' 			=> $newToken,
    	]);
    }
}
