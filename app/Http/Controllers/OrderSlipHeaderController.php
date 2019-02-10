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
<<<<<<< HEAD
use App\KitchenOrder;
use App\SitePart;
=======
>>>>>>> 53f3bd2f58055f2bb006515642285623316a1042
use DB;


class OrderSlipHeaderController extends Controller
{
<<<<<<< HEAD
    //

=======
    // not a transaction 
>>>>>>> 53f3bd2f58055f2bb006515642285623316a1042
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
<<<<<<< HEAD
=======


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
>>>>>>> 53f3bd2f58055f2bb006515642285623316a1042

                // dd([
                //     'branch_id'    => $cce->BRANCHID,
                //     'order_slip_no'=> $new_header
                // ]);

<<<<<<< HEAD
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
            $clarion = new Carbon();
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
            // $order_header->ORIGINALINVOICEDATE = $clarion->today();

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
=======
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
>>>>>>> 53f3bd2f58055f2bb006515642285623316a1042


    public function insertFoodOrder(Request $request){
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
            $clarion = new Carbon();
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
            
            $order_header->SC_COUNT       = $request->sc_count;
            $order_header->PWD_COUNT      = $request->pwd_count;
            $order_header->TOTALHEADCOUNT = $request->total_head_count;


            // $order_header->ORIGINALINVOICEDATE = $clarion->today();

            $order_header->save();
             
           //save the items into details using the new header_no from above and user the details_no = details_no + 1   
            /* foreach ($request->items as $item) {    
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
                
             } */
               $clarion_today = new Clarion();
              
             
            foreach ($request->items as $item) {    
                $new_details = $new_details + 1 ;
                $order_details = new OrderSlipDetails(); 
                $order_details->BRANCHID            = $cce->BRANCHID;
                $order_details->ORDERSLIPNO         = $new_header;
                $order_details->ORDERSLIPDETAILID   = $new_details;
                $order_details->ENCODEDDATE         = $now;
                $order_details->PRODUCT_ID          = $item['id'];
                $order_details->PARTNO              = $item['part_no'];
                $order_details->PRODUCTGROUP        = $item['group_no'];
                $order_details->QUANTITY            = $item['qty'];         
                $order_details->RETAILPRICE         = $item['o_price'];
                $order_details->AMOUNT              = $item['subtotal'];
                $order_details->ISPERCENT           = 0;
                $order_details->DISCOUNT            = 0;
                $order_details->CUSTOMERCODE        = $order_header->CUSTOMERCODE;
                $order_details->NETAMOUNT           = $order_details->AMOUNT - $order_details->DISCOUNT;
                $order_details->STATUS               = "P";
                $order_details->OSTYPE              = $item['ordertype'];
                $order_details->save();
                
    
                /*  
                if ($item['postmix'] == 1) {

                  $lastIssuedOrder->kitchen_order_no = $lastIssuedOrder->kitchen_order_no  +1;
                  $lastIssuedOrder->save();                  
                  $kitchen_order = new KitchenOrder();
                  $kitchen_no = $lastIssuedOrder->kitchen_order_no;

                  $kitchen_order->branch_id       = $cce->BRANCHID;
                  $kitchen_order->ko_id           = $kitchen_no;
                  $kitchen_order->transact_type   = 1; 
                  $kitchen_order->header_id       = $order_header->ORDERSLIPNO;
                  $kitchen_order->detail_id       = $new_details;
                  $kitchen_order->part_id         = $item['id'];
                  $kitchen_order->comp_id         = $item['id'];
                  $kitchen_order->location_id     = $item['location'];
                  $kitchen_order->QTY             = $item['qty'];
                  $kitchen_order->USED            = 0;
                  $kitchen_order->BALANCE         = $item['qty'];
                  $kitchen_order->STATUS          = 'P';

                  $kitchen_order->issued_date     = $clarion_today->today();

                  $kitchen_order->issued_time     = $this->getClarionTime($now);
                  $kitchen_order->created_at      = $now;
                  $kitchen_order->CREATED_DATE    = $clarion_today->today();
                  $kitchen_order->CREATED_TIME    = $this->getClarionTime($now);
                  $kitchen_order->save();

                  
                  foreach ($item['components'] as $component) {
                    if ($component['qty'] > 0 && $component['modifiable'] == 1 ) {
                      $lastIssuedOrder->kitchen_order_no = $lastIssuedOrder->kitchen_order_no  +1;
                      $lastIssuedOrder->save();                  
                      $kitchen_order = new KitchenOrder();
                      $kitchen_no = $lastIssuedOrder->kitchen_order_no;
                      
                      $kitchen_order->branch_id       = $cce->BRANCHID;
                      $kitchen_order->ko_id           = $kitchen_no;
                      $kitchen_order->transact_type   = 1; 
                      $kitchen_order->header_id       = $order_header->ORDERSLIPNO;
                      $kitchen_order->detail_id       = $new_details;
                      $kitchen_order->part_id         = $item['id'];

                      $kitchen_order->comp_id         = $component['component_id'];
                      $kitchen_order->location_id     = $component['location'];
                      $kitchen_order->QTY             = $component['qty'];
                      $kitchen_order->USED            = 0;
                      $kitchen_order->BALANCE         = $component['qty'];
                      $kitchen_order->STATUS          = 'P';

                      $kitchen_order->issued_date     = $clarion_today->today();
                      
                      $kitchen_order->issued_time     = $this->getClarionTime($now);
                      $kitchen_order->created_at      = $now;
                      $kitchen_order->CREATED_DATE    = $clarion_today->today();
                      $kitchen_order->CREATED_TIME    = $this->getClarionTime($now);
                      $kitchen_order->save();
                                            
                    }
                  }

                }else{
                  $kitchen_order = new KitchenOrder();
                  $lastIssuedOrder->kitchen_order_no = $lastIssuedOrder->kitchen_order_no  +1;
                  $lastIssuedOrder->save(); 
                  $kitchen_order = new KitchenOrder();
                  $kitchen_order->branch_id       = $cce->BRANCHID;
                  $kitchen_order->transact_type   = 1; 
                  $kitchen_order->header_id       = $order_header->ORDERSLIPNO;
                  $kitchen_order->detail_id       = $new_details;
                  $kitchen_order->part_id         = $item['id'];
                  $kitchen_order->comp_id         = $item['id'];
                  $kitchen_order->location_id     = $item['location'];
                  $kitchen_order->QTY             = $item['qty'];
                  $kitchen_no = $lastIssuedOrder->kitchen_order_no;
                  $kitchen_order->ko_id           = $kitchen_no++;
                  $kitchen_order->save();  
                }*/
             
               
              
               /* $kitchen_no = 0;
                if ($item['partstype'] == "N" || $item['partstype'] == "") {
                  $lastIssuedOrder->kitchen_order_no = $lastIssuedOrder->kitchen_order_no  +1;
                  $lastIssuedOrder->save(); 
                  $kitchen_order = new KitchenOrder();
                  $kitchen_no = $lastIssuedOrder->kitchen_order_no+1;
                  $kitchen_order->branch_id       = $cce->BRANCHID;
                  $kitchen_order->ko_id           = $kitchen_no;
                  $kitchen_order->transact_type   = 1; 
                  $kitchen_order->header_id       = $order_header->ORDERSLIPNO;
                  $kitchen_order->detail_id       = $new_details;
                  $kitchen_order->part_id         = $item['id'];
                  $kitchen_order->comp_id         = $component['component_id'];
                  $kitchen_order->location_id     = $component['location'];
                  $kitchen_order->QTY             = $component['qty'];
                  $kitchen_order->USED            = 0;
                  $kitchen_order->BALANCE         = $component['qty'];
                  $kitchen_order->STATUS          = 'P';

                  $kitchen_order->issued_date     = $clarion_today->today();
                  
                  $kitchen_order->issued_time     = $this->getClarionTime($now);
                  $kitchen_order->created_at      = $now;
                  $kitchen_order->CREATED_DATE    = $clarion_today->today();
                  $kitchen_order->CREATED_TIME    = $this->getClarionTime($now);
                  $kitchen_order->save();
                  $kitchen_order->save();
                }else{
                  foreach ($item['components'] as $component) {
                    if ($component['qty'] > 0) {
                      $lastIssuedOrder->kitchen_order_no+1;
                      $lastIssuedOrder->save();                  
                      $kitchen_order = new KitchenOrder();
                      $kitchen_no = $lastIssuedOrder->kitchen_order_no+1;
                      
                      $kitchen_order->branch_id       = $cce->BRANCHID;
                      $kitchen_order->ko_id           = $kitchen_no;
                      $kitchen_order->transact_type   = 1; 
                      $kitchen_order->header_id       = $order_header->ORDERSLIPNO;
                      $kitchen_order->detail_id       = $new_details;
                      $kitchen_order->part_id         = $item['id'];
                      $kitchen_order->comp_id         = $component['component_id'];
                      $kitchen_order->location_id     = $component['location'];
                      $kitchen_order->QTY             = $component['qty'];
                      $kitchen_order->USED            = 0;
                      $kitchen_order->BALANCE         = $component['qty'];
                      $kitchen_order->STATUS          = 'P';

                      $kitchen_order->issued_date     = $clarion_today->today();
                      
                      $kitchen_order->issued_time     = $this->getClarionTime($now);
                      $kitchen_order->created_at      = $now;
                      $kitchen_order->CREATED_DATE    = $clarion_today->today();
                      $kitchen_order->CREATED_TIME    = $this->getClarionTime($now);
                      $kitchen_order->save();
                                            
                    }
                  }
                }*/
              if ($item['postmix'] == 1) {
                                foreach ($item['components'] as $component) {
                                  if ($component['modifiable'] == 1 || $component['display']) {

                                    $prod = SitePart::where("PRODUCT_ID", $component['component_id'])
                                    ->where("ARNOC", $cce->BRANCHID)
                                    ->first();

                                    if (is_null($prod)) {
                                      # code...
                                    }
                                    
                                    $new_details = $new_details + 1 ;
                                    $order_details = new OrderSlipDetails(); 
                                    $order_details->BRANCHID            = $cce->BRANCHID;
                                    $order_details->ORDERSLIPNO         = $new_header;
                                    $order_details->ORDERSLIPDETAILID   = $new_details;
                                    $order_details->ENCODEDDATE         = $now;
                                    $order_details->PRODUCT_ID          = $component['component_id'];
                                    $order_details->PARTNO              = $prod->PARTNO;
                                    $order_details->PRODUCTGROUP        = $prod->GROUP;
                                    $order_details->QUANTITY            = $component['qty'];         
                                    $order_details->RETAILPRICE         = $component['price'];
                                    $order_details->AMOUNT              = $component['subtotal'];
                                    $order_details->ISPERCENT           = 0;
                                    $order_details->DISCOUNT            = 0;
                                    $order_details->CUSTOMERCODE        = $order_header->CUSTOMERCODE;
                                    $order_details->NETAMOUNT           = $order_details->AMOUNT - $order_details->DISCOUNT;
                                    $order_details->STATUS               = "P";
                                    $order_details->OSTYPE              = $item['ordertype'];
                                    
                                    $order_details->ORNO                = $order_details->ORDERSLIPDETAILID;
                                    $order_details->POSTMIXID           = $item['id'];  
                                    
                                    $order_details->save();
                                  }
                                }
                              }
                
            }

            

            //save the last issued number[ header and details ] for the branch in OrderLastIssuedNumber
            $lastIssuedOrder->order_slip_header_no    = $new_header;
            $lastIssuedOrder->order_slip_detail_no    = $new_details;   
            $lastIssuedOrder->save();  


            //return a response for the status of transaction....

           
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


    public function getClarionTime(Carbon $date){
        $date = Carbon::now();
        $startOfTheDay = Carbon::create(
            $date->year, $date->month, $date->day, 
            0, 0, 0);
        $result = $startOfTheDay->diffInSeconds($date);
        return $result * 100;
    }
}
