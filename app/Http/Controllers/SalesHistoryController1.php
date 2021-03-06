<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\OrderSlipHeader;
use App\Customer;
use App\Transformer\OrderSlipHeaderTransformer;
class SalesHistoryController extends Controller
{

 
	public function getSalesTotal(Request $request){

		$isToday = $request->isToday;
		$from 	= null;
		$to 	= null;
		
		if ($isToday == 0) {

			if($request->from == null || $request->to == null){
				return response()->json([
					'success'	=> true,
					'status' 	=> 200,
					'message'		=> 'Date is required'
				]);
			}

			$from = Carbon::parse($request->from); 
			$from = Carbon::create($from->year, $from->month, $from->day, 0, 0, 0);

			$to = Carbon::parse($request->to); 
			$to = Carbon::create($to->year, $to->month, $to->day, 23, 59, 59);	

		}else{

			$from = Carbon::now();
			$to = Carbon::now();

			$from = Carbon::parse($from);
			$from = Carbon::create($from->year, $from->month, $from->day, 0, 0, 0);

			$to = Carbon::parse($to); 
			$to = Carbon::create($to->year, $to->month, $to->day, 23, 59, 59);	

		}
		
		$cce_num = $request->cce_num;
		$cce_branch = $request->cce_branch; 

		//$result = OrderSlipHeader::whereBetween('OSDATE', [$from, $to])->get();
		$result = OrderSlipHeader::where('OSDATE', '>=', $from)
								->where('OSDATE', '<=', $to)
								->where('TRANSACTTYPEID', '=', 2)
								->where('ENCODEDBY', '=', $cce_num)
								->where('BRANCHID' , '=', $cce_branch)
								->get();

		$netAmount = $result->sum('TOTALAMOUNT');
		
		return response()->json([
			'success'	=> true,
			'status' 	=> 200,
			'data'		=>[
				'total' 	=> $netAmount,
				'from'		=> $from->toDateString(),
				'to'		=> $to->toDateString()
			]
		]);
	}	

	public function getSalesHistory(Request $request){
		
		$customer_name 	= $request->customer_name;		
		$order_no 		= $request->os_header_no;
		$cce_num 		= $request->cce_num;
		$cce_branch 	= $request->cce_branch; 
		$status 		= $request->status;

		$isToday 		= $request->isToday;
		// $from 			= Carbon::now();
		// $to 			= Carbon::now();
		
		// if ($isToday == 0) { 

		// 	$from = Carbon::parse($request->from);
		// 	$from = Carbon::create($from->year, $from->month, $from->day, 0, 0, 0);
			
		// 	$to = Carbon::parse($request->to); 
		// 	$to = Carbon::create($to->year, $to->month, $to->day, 23, 59, 59);	
		// }

		if ($isToday == 0) {

			if($request->from == null || $request->to == null){
				return response()->json([
					'success'	=> false,
					'status' 	=> 400,
					'message'		=> 'Date is required'
				]);
			}

			$from = Carbon::parse($request->from); 
			$from = Carbon::create($from->year, $from->month, $from->day, 0, 0, 0);

			$to = Carbon::parse($request->to); 
			$to = Carbon::create($to->year, $to->month, $to->day, 23, 59, 59);	

		}else{

			$from = Carbon::now();
			$to = Carbon::now();

			$from = Carbon::parse($from);
			$from = Carbon::create($from->year, $from->month, $from->day, 0, 0, 0);

			$to = Carbon::parse($to); 
			$to = Carbon::create($to->year, $to->month, $to->day, 23, 59, 59);	

		}

		$ost = new OrderSlipHeaderTransformer();
		


		if (is_null($order_no)) {	
				//dd($order_no, $cce_num);	
			$result = OrderSlipHeader::
						where('OSDATE', '>=', $from)
						->where('OSDATE', '<=', $to)
						->where('TRANSACTTYPEID', '=', 2)
						->where('ENCODEDBY', '=', $cce_num)
						->where('BRANCHID' , '=', $cce_branch)
						->where('CUSTOMERNAME', 'LIKE', '%'.$customer_name.'%')
						->where('STATUS', 'LIKE', '%'.$status.'%')
						->Paginate();
	   

	    	$newData = $ost->osHeaders($result);
	    	
		}else{
				
			$result = OrderSlipHeader::
						where('ORDERSLIPNO', $order_no)
						->where('OSDATE', '>=', $from)
						->where('OSDATE', '<=', $to)
						->where('TRANSACTTYPEID', '=', 2)
						->where('ENCODEDBY', $cce_num)
						->where('STATUS', 'LIKE', '%'.$status.'%')
						->first();
			 
			if(is_null($result)){
				return response()->json([
					'success'	=> false,
					'status' 	=> 400,
					'message'		=> 'No data was found associated with your transaction'
				]);
			}

			$newData = $ost->osHeader($result);
		}		

		return response()->json([
			'success'	=> true,
			'status' 	=> 200,
			'data'		=>[	
				'from'		=> $from->toDateString(),
				'to'		=> $to->toDateString(),
				'orders'	=> $newData
			]
		]);
	}



	public function getSalesOrder(Request $request){
		$os_no = $request->os_no;
		if(is_null($os_no)){
			return response()->json([
				'success'	=> false,
				'status' 	=> 400,
				'message'		=> 'No data was found associated with your transaction'
			]);
		}


		$result = OrderSlipDetails::where('ORDERSLIPNO',  $os_no)->first();
		// pakita rin yung sa product 

	}
}
