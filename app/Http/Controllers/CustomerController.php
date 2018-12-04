<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\WebUser;
use App\Customer;
use App\UserSite;
use App\Custom\CheckOnDuty;
use App\OrderLastIssuedNumber;


class CustomerController extends Controller
{

	public function createNewCustomer(Request $request){

		$token = $request->header('token');
		$user = UserSite::findByToken($token);
		if(is_null($user)){
			return response()->json([
				'success' 	=> false,
				'message' 	=> "Invalid Token"
			]);
		}

		// to get the arnoc of the on duty 
		// meaning the customer was registered at that branch
		$cce = CheckOnDuty::cceOnDuty($user->NUMBER);
		$cce_branch_id = $cce->BRANCHID;
		$lastIssuedOrder =  OrderLastIssuedNumber::findByBranch($cce->BRANCHID);

    	// if theres no existing customer in the branch
		if (is_null($lastIssuedOrder)) {

			$lastIssuedOrder = new OrderLastIssuedNumber();
			$lastIssuedOrder->order_slip_header_no 	= 0;
			$lastIssuedOrder->order_slip_detail_no	= 0; 
			$lastIssuedOrder->branch_id 			= $cce_branch_id;  	
			$lastIssuedOrder->customer_no 			= 1;
			$lastIssuedOrder->save();

		}else{
			$new_customer_no = $lastIssuedOrder->customer_no + 1;
			$lastIssuedOrder->customer_no = $new_customer_no;
			$lastIssuedOrder->save();
		}

		
    	// add first to the web_users 
		$web_user = new WebUser();
		$web_user->name 			= $request->name;
		$web_user->email 			= $request->email;
		$web_user->mobile_number 	= $request->mobile_number;
		$web_user->password 		= md5($request->password);
		$web_user->save();

		// get the id of the user
		$user_id = $web_user->id;


		// save the details to the customer
		$customer = new Customer();
		$customer->BRANCHID 		= $cce->BRANCHID; 
		$customer->CUSTOMERID		= $new_customer_no;
		$customer->NAME 			= $web_user->name; 
		$customer->user_id 			= $user_id;
		$customer->mobile_number 	= $request->mobile_number;
		$customer->birthdate 		= $request->bday;
		$customer->is_loyalty 		= $request->is_loyalty;
		$customer->is_inhouse 		= 0;
		$customer->save();		

		return response()->json([
			'success'   => true,
			'status'    => 200,
			'message' 	=> "Successfully added a new customer",
			'data'		=> [
				'user_id' => $customer->user_id,  
				'customer_id' => $customer->CUSTOMERID  
			]
			
		]);
	}


	/*
		Search customer thru name and 
	*/

		public function searchCustomer(Request $request){
			$search_value = $request->get('search_value');
			$customer = Customer::with('user')
					->where('NAME','LIKE', '%'.$search_value.'%')
					->orwhere('mobile_number',  '=', $search_value )
					->Paginate();

			return response()->json([
				'success'   => true,
				'status'    => 200,
				'data' => $customer
			]);

		}

		public function customerPhoneExists(Request $request){
			$search_value = $request->get('search_value');
			$customer = Customer::where('mobile_number', '=', $search_value)
			->first();
			if (is_null($customer)) {
				return response()->json([
					'success'   => true,
					'status'    => 200,
					'data' 		=> false
				]);
			}
			
			return response()->json([
				'success'   => true,
				'status'    => 200,
				'data' 		=> true
			]);
		}
	}
