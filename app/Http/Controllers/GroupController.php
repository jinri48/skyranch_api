<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class GroupController extends Controller
{
    public function index(){
    		
    	$product_groups = Group::get();

    	return response()->json([
    		'success' => "true",
    		'status'  => 200,
    		'data'	 => $product_groups
    	]);
    }


    public function groups(){

    	$product_groups = Group::whereNotIn("GROUPCODE", array(12, 13))
    			->get();

    	return response()->json([
    		'success' => "true",
    		'status'  => 200,
    		'data'	 => $product_groups
    	]);
    }


    public function groupsLoc(Request $request){

        $location = $request->get('location');

        if (is_null($location)) {
            return response()->json([
                'success' => "false",
                'status'  => 200,
                'message'   => "location is required"
            ]);    
                   
        }

        if ($location == 1) { //admission
            $product_groups = Group::whereIn("BSUNITCODE", array(3,4))
            ->get();            
        }else if($location == 2){ // food
            $product_groups = Group::whereIn("BSUNITCODE", array(2))
                ->whereNotIn("GROUPCODE", array(12, 13))
                ->get();
        }else if ($location == 3) { // souvenir
            $product_groups = Group::whereIn("BSUNITCODE", array(1, 4))
                ->get();
        }

        // $product_groups = Group::whereNotIn("GROUPCODE", array(12, 13))
        //         ->get();

        return response()->json([
            'success' => "true",
            'status'  => 200,
            'data'   => $product_groups
        ]);
    }
}
