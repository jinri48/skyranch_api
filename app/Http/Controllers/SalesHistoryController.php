<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\OrderSlipHeader;

class SalesHistoryController extends Controller
{


	public function getSalesTotal(Request $request){

		$isToday = $request->isToday;
		$from = Carbon::now();
		$to = Carbon::now();
		
		if ($isToday == 0) {
			$from = Carbon::parse($request->from);
			$from = Carbon::create($from->year, $from->month, $from->day, 0, 0, 0);

			$to = Carbon::parse($request->to); 
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
		
		$isToday = $request->isToday;
		$from = Carbon::now();
		$to = Carbon::now();
		
		if ($isToday == 0) {
			$from = Carbon::parse($request->from);
			$from = Carbon::create($from->year, $from->month, $from->day, 0, 0, 0);

			$to = Carbon::parse($request->to); 
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
								->Paginate();
		
		return response()->json([
			'success'	=> true,
			'status' 	=> 200,
			'data'		=>[	
				'from'		=> $from->toDateString(),
				'to'		=> $to->toDateString(),
				'orders'	=> $result
			]
		]);
	}


}
