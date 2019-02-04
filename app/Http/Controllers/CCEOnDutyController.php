<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clarion;
use App\UserSite;
use App\CCEOnDuty;


class CCEOnDutyController extends Controller
{
    public function isOnDuty(Request $request){
    	$user = UserSite::findByToken($request->get('token'));     
        if(is_null($user) || $request->get('token')==null){
            return response()->json([
                'success'           => false,
                'status'            => 401,
                'message'           => 'Unauthenticated Request',
                'code'              => null
            ]);
        }

        //check if on duty
        $c      = new Clarion;      
        $cce    = new CCEOnDuty;    
         

        if( is_null($cce->isOnDuty(trim($user->NUMBER), $c->today())) ){

            return response()->json([
                'success'           => false,
                'status'            => 401,
                'message'           => 'Not on Duty!',
                'code'              => '1'
            ]);

        }
    }
}
