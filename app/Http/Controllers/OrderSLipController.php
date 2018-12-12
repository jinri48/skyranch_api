<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//models
use App\SitePart;
use App\UserSite;
use App\Custom\CheckOnDuty;
use App\OrderSlipDetails;


class OrderSLipController extends Controller
{
    //
    public function detailsPerHeader(Request $request, $id){

    	$token 	= $request->header('token');

    	//getting the user by token
    	$user 	= UserSite::findByToken($token);
    	if(is_null($user) || $token == null){
    		return response()->json([
    			'success' 	=> false,
    			'status' 	=> 401,
    			'message' 	=> "Invalid Token"
    		]);
    	}

    	//getting the branch id of logged user
    	$cce = CheckOnDuty::cceOnDuty($user->NUMBER);
 
 		//getting the details of order slip header id
    	$osd = new OrderSlipDetails;
    	$osd = $osd->where('BRANCHID', $cce->BRANCHID)
    			->where('ORDERSLIPNO', $id)
    			->get();

    	//rewriting the result into filtered columns
    	$osd->transform(function($val){

    		// to get the detials of product per detail
    		$sp = new SitePart; 
    		$sp = $sp->where('ARNOC', $val->BRANCHID)
    				->where('PRODUCT_ID', $val->PRODUCT_ID)
    				->first();

    		return [
    			'order_detail_id' 	=> $val->ORDERSLIPDETAILID,
    			'product_id' 		=> $val->PRODUCT_ID,
    			'product_name' 		=> trim($sp->DESCRIPTION),
    			'part_number' 		=> trim($val->PARTNO),
    			'qty' 				=> $this->replaceIfNull($val->QUANTITY, 0),
    			'srp' 				=> $this->replaceIfNull($val->RETAILPRICE, 0),
    			'amount' 			=> $this->replaceIfNull($val->AMOUNT, 0),
    			'discount' 			=> $this->replaceIfNull($val->DISCOUNT, 0),
    			'net_amount' 		=> $this->replaceIfNull($val->NETAMOUNT, 0),
    			'status' 			=> $this->replaceIfNull($val->STATUS,''),
               
    		];
    	});

    	return response()->json([
    		'success' 	=> true,
    		'status' 	=> 200,
    		'data' 		=> $osd
    	]);

    }

    private function replaceIfNull($val,$newVal){
    	if($val == null){
    		return $newVal;
    	}
    	return $val;
    }
}
