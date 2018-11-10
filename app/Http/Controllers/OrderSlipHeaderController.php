<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserSite;
use App\Clarion;
use App\CCEOnDuty;
use App\OrderLastIssuedNumber;
use App\OrderSlipHeader;
use App\OrderSlipDetails;
use Carbon\Carbon;


class OrderSlipHeaderController extends Controller
{
    //

    public function insertOrder(Request $request){


    	// $token = $request->header('token');
        // check if the user exists in the user by token
        $token = $request->token;
    	$user = UserSite::findByToken($token);
    	if(is_null($user)){
    		return response()->json([
    			'success' 	=> false
    		]);
    	}

        // get the record if its his onduty for the day
    	$cce = $this->checkOnDuty($user->NUMBER);
    
    	// check brand_id if exist on OrderLastIssu....
    	$cce_branch_id = $cce->BRANCHID;
    	$lastIssuedOrder =  OrderLastIssuedNumber::findByBranch($cce->BRANCHID);
    	$new_header=0; $new_details=0;
    	
    	//if false make a new one with header=0 details=0
    	if (is_null($lastIssuedOrder)) {
			$lastIssuedOrder = new OrderLastIssuedNumber();
			$lastIssuedOrder->header_no 	= 0;
			$lastIssuedOrder->details_no	= 0; 
			$lastIssuedOrder->branch_id 	= $cce_branch_id;  	
			$lastIssuedOrder->save();
			
            $new_header  =  $lastIssuedOrder->header_no + 1;
            $new_details =  $lastIssuedOrder->details_no;
    	}else{ 	//if true, get the current header and details
    		$new_header  =  $lastIssuedOrder->header_no + 1;
    		$new_details =  $lastIssuedOrder->details_no;
            //lastIssuedOrder->branch_id = $cce_branch_id; 
    	}
        
    	//save the item summary from cart with the new header_no = header+1
        $now = Carbon::now();  
        $order_header =  new OrderSlipHeader();
        $order_header->BRANCHID     = (int) $cce->BRANCHID;
        $order_header->ORDERSLIPNO  = $new_header;
        $order_header->TOTALAMOUNT  = $request->total_amount;
        $order_header->OSDATE       = $now;
        $order_header->ENCODEDDATE  = $now; 
        $order_header->STATUS       = "P";
        $order_header->ENCODEDBY    = (int) $user->NUMBER;
        $order_header->PREPAREDBY   = trim($user->NAME);
        $order_header->CCENAME      = trim($user->NAME);
        $order_header->save();
         
    	//save the items into details using the new header_no from above and user the details_no = details_no + 1   
         foreach ($request->items as $item) {    
            $new_details++;
            $order_details = new OrderSlipDetails(); 
            $order_details->BRANCHID            = $cce->BRANCHID;
            $order_details->ORDERSLIPNO         = $new_header;
            $order_details->ORDERSLIPDETAILID   = $new_details;
            $order_details->ENCODEDDATE         = $now;
            $order_details->PRODUCT_ID          = $item['product_id'];
            $order_details->PARTNO              = $item['product_part_no'];
            $order_details->PRODUCTGROUP        = $item['product_group_no'];
            $order_details->QUANTITY            = $item['qty'];         
            $order_details->RETAILPRICE         = $item['product_retail_price'];
            $order_details->AMOUNT              = $item['subtotal'];
            // return response()->json([
            //     'success'   => false,
            //     'od'        => $order_details
            // ]);
            $order_details->save();
            
         } 
        

        //save the last issued number[ header and details ] for the branch in OrderLastIssuedNumber
        $lastIssuedOrder->header_no     = $new_header;
        $lastIssuedOrder->details_no    = $new_details;   
        $lastIssuedOrder->save();  


    	//return a response for the status of transaction....

        // dd([
        //     'branch_id'    => $cce->BRANCHID,
        //     'order_slip_no'=> $new_header
        // ]);
        return response()->json([
            'success'   => true,
            'status'    => 200
        ]);

    }

    public function checkOnDuty($number){
    	//check if on duty
        $c      = new Clarion;      
        $cce    = new CCEOnDuty;     

        $result = $cce->isOnDuty(trim($number), $c->today() );
        if( is_null($result) ){
            return false;
        }  
        return $result;
    }



}
