<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserSite;
use App\Clarion;
use App\OrderLastIssuedNumber;
use App\OrderSlipHeader;
use App\OrderSlipDetails;
use Carbon\Carbon;
use App\Custom\CheckOnDuty;
use DB;


class OrderSlipHeaderController extends Controller
{
    // not a transaction 
   //  public function insertOrder(Request $request){


   //  	$token = $request->header('token');

   //      // check if the user exists in the user by token
   //      // $token = $request->token;
   //  	$user = UserSite::findByToken($token);
    
   //      if(is_null($user)){
   //  		return response()->json([
   //  			'success' 	=> false,
   //              'message'   => "Invalid Token"
   //  		]);
   //  	}


   //      // get the record if its his onduty for the day
   //  	//$cce = $this->checkOnDuty($user->NUMBER);

   //      $cce = CheckOnDuty::cceOnDuty($user->NUMBER);
       
   //  	// check branH_id if exist on OrderLastIssu....
   //  	$cce_branch_id = $cce->BRANCHID;
   //  	$lastIssuedOrder =  OrderLastIssuedNumber::findByBranch($cce->BRANCHID);
   //  	$new_header=0; $new_details=0;
    	
   //  	//if false make a new one with header=0 details=0
   //  	if (is_null($lastIssuedOrder)) {
			// $lastIssuedOrder = new OrderLastIssuedNumber();
			// $lastIssuedOrder->order_slip_header_no 	= 0;
			// $lastIssuedOrder->order_slip_detail_no	= 0; 
			// $lastIssuedOrder->branch_id 	= $cce_branch_id; 	
   //          $lastIssuedOrder->customer      = 0;
			// $lastIssuedOrder->save();
			
   //          $new_header  =  $lastIssuedOrder->order_slip_header_no + 1;
   //          $new_details =  $lastIssuedOrder->order_slip_detail_no;
   //  	}else{ 	//if true, get the current header and details
   //  		$new_header  =  $lastIssuedOrder->order_slip_header_no + 1;
   //  		$new_details =  $lastIssuedOrder->order_slip_detail_no;
   //          //lastIssuedOrder->branch_id = $cce_branch_id; 
   //  	}
        
   //  	//save the item summary from cart with the new header_no = header+1
   //      $now = Carbon::now();  
   //      $order_header =  new OrderSlipHeader();
   //      $order_header->BRANCHID     = (int) $cce->BRANCHID;
   //      $order_header->ORDERSLIPNO  = $new_header;
   //      $order_header->TOTALAMOUNT  = $request->total_amount;
   //      $order_header->OSDATE       = $now;
   //      $order_header->ENCODEDDATE  = $now; 
   //      $order_header->STATUS       = "P";
   //      $order_header->ENCODEDBY    = (int) $user->NUMBER;
   //      $order_header->PREPAREDBY   = trim($user->NAME);
   //      $order_header->CCENAME      = trim($user->NAME);
   //      $order_header->TRANSACTTYPEID = 2;
   //      $order_header->CUSTOMERCODE     = $request->customer_no;
   //      $order_header->CUSTOMERNAME     = $request->customer_name;
   //      $order_header->CELLULARNUMBER   = $request->customer_mobile;
   //      $order_header->NETAMOUNT        = $order_header->TOTALAMOUNT - $order_header->DISCOUNT;

   //      $order_header->save();
         
   //  	//save the items into details using the new header_no from above and user the details_no = details_no + 1   
   //       foreach ($request->items as $item) {    
   //          $new_details++;
   //          $order_details = new OrderSlipDetails(); 
   //          $order_details->BRANCHID            = $cce->BRANCHID;
   //          $order_details->ORDERSLIPNO         = $new_header;
   //          $order_details->ORDERSLIPDETAILID   = $new_details;
   //          $order_details->ENCODEDDATE         = $now;
   //          $order_details->PRODUCT_ID          = $item['product_id'];
   //          $order_details->PARTNO              = $item['product_part_no'];
   //          $order_details->PRODUCTGROUP        = $item['product_group_no'];
   //          $order_details->QUANTITY            = $item['qty'];         
   //          $order_details->RETAILPRICE         = $item['product_retail_price'];
   //          $order_details->AMOUNT              = $item['subtotal'];
   //          $order_details->ISPERCENT           = 0;
   //          $order_details->DISCOUNT            = 0;
   //          $order_details->CUSTOMERCODE        = $order_header->CUSTOMERCODE;
   //          $order_details->NETAMOUNT           = $order_details->AMOUNT - $order_details->DISCOUNT;
   //          $order_details->STATUS               = "P";


   //          // return response()->json([
   //          //     'success'   => false,
   //          //     'od'        => $order_details
   //          // ]);
   //          $order_details->save();
            
   //       } 
        

   //      //save the last issued number[ header and details ] for the branch in OrderLastIssuedNumber
   //      $lastIssuedOrder->order_slip_header_no    = $new_header;
   //      $lastIssuedOrder->order_slip_detail_no    = $new_details;   
   //      $lastIssuedOrder->save();  


   //  	//return a response for the status of transaction....

   //      // dd([
   //      //     'branch_id'    => $cce->BRANCHID,
   //      //     'order_slip_no'=> $new_header
   //      // ]);

   //      return response()->json([
   //          'success'   => true,
   //          'status'    => 200, 
   //          'order_header' => sprintf("%'.02d", $order_header->ORDERSLIPNO)
   //      ]);

   //  }   

    // transaction
    public function insertOrder(Request $request){
            try{

                //begin
                DB::beginTransaction();

                //==========================

                $token = $request->header('token');

                // check if the user exists in the user by token
                // $token = $request->token;
                $user = UserSite::findByToken($token);
                
                if(is_null($user)){
                    return response()->json([
                        'success'   => false,
                        'message'   => "Invalid Token"
                    ]);
                }


                // get the record if its his onduty for the day
                //$cce = $this->checkOnDuty($user->NUMBER);

                $cce = CheckOnDuty::cceOnDuty($user->NUMBER);
                
                // check branH_id if exist on OrderLastIssu....
                $cce_branch_id = $cce->BRANCHID;
                $lastIssuedOrder =  OrderLastIssuedNumber::findByBranch($cce->BRANCHID);
                $new_header=0; $new_details=0;
                
                //if false make a new one with header=0 details=0
                if (is_null($lastIssuedOrder)) {
                    $lastIssuedOrder = new OrderLastIssuedNumber();
                    $lastIssuedOrder->order_slip_header_no  = 0;
                    $lastIssuedOrder->order_slip_detail_no  = 0; 
                    $lastIssuedOrder->branch_id     = $cce_branch_id;   
                    $lastIssuedOrder->customer      = 0;
                    $lastIssuedOrder->save();
                    
                    $new_header  =  $lastIssuedOrder->order_slip_header_no + 1;
                    $new_details =  $lastIssuedOrder->order_slip_detail_no;
                }else{  //if true, get the current header and details
                    $new_header  =  $lastIssuedOrder->order_slip_header_no + 1;
                    $new_details =  $lastIssuedOrder->order_slip_detail_no;
                    //lastIssuedOrder->branch_id = $cce_branch_id; 
                }
                
                //save the item summary from cart with the new header_no = header+1
                $now = Carbon::now();  
                $clarion = new Clarion();
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
                $order_header->TRANSACTTYPEID = 2;
                $order_header->CUSTOMERCODE     = $request->customer_no;
                $order_header->CUSTOMERNAME     = $request->customer_name;
                $order_header->CELLULARNUMBER   = $request->customer_mobile;
                $order_header->NETAMOUNT        = $order_header->TOTALAMOUNT - $order_header->DISCOUNT;
                $order_header->ORIGINALINVOICEDATE = $clarion->today();
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
                    $order_details->ISPERCENT           = 0;
                    $order_details->DISCOUNT            = 0;
                    $order_details->CUSTOMERCODE        = $order_header->CUSTOMERCODE;
                    $order_details->NETAMOUNT           = $order_details->AMOUNT - $order_details->DISCOUNT;
                    $order_details->STATUS               = "P";


                    // return response()->json([
                    //     'success'   => false,
                    //     'od'        => $order_details
                    // ]);
                    $order_details->save();
                    
                 } 
                

                //save the last issued number[ header and details ] for the branch in OrderLastIssuedNumber
                $lastIssuedOrder->order_slip_header_no    = $new_header;
                $lastIssuedOrder->order_slip_detail_no    = $new_details;   
                $lastIssuedOrder->save();  


                //return a response for the status of transaction....

                // dd([
                //     'branch_id'    => $cce->BRANCHID,
                //     'order_slip_no'=> $new_header
                // ]);

                //==========================
                //success 
                DB::commit(); // this will save all the changes into the database before returning a response from the client.

                return response()->json([
                    'success'   => true,
                    'status'    => 200, 
                    'order_header' => sprintf("%'.02d", $order_header->ORDERSLIPNO)
                ]);

            }catch(\Exception $e){
                //fail
                DB::rollback();

                return response()->json([
                        'success'   => false,
                        'status'    => 200,
                        'message'   => $e->getMessage()
                ]);
            }
        }   

}
