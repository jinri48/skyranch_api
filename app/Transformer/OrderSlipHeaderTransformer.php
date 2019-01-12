<?php
namespace App\Transformer;
/**
 * 
 */
use App\Customer;
class OrderSlipHeaderTransformer
{
	
	public function osHeaders($data){
		
		$data->getCollection()->transform(function ($value){
			
			$customer = Customer::where('CUSTOMERID',$value->CUSTOMERCODE)
								->where('BRANCHID', $value->BRANCHID)
								->first();
			if (is_null($customer)) {
				$customerID = NULL;
				$customerName = NULL;
				$customerMobile = NULL;
			}else{
				$customerID = $customer->CUSTOMERID;
				$customerName = $customer->NAME;
				// $customerMobile = $customer->mobile_number;
				$customerMobile = $customer->MOBILE_NUMBER;
			}

			$newData = [
			'branch_id' 		=> $value->BRANCHID, 
			'os_no' 			=> (int) $value->ORDERSLIPNO,
			'os_date' 			=> $value->OSDATE,
			'encoded_by'		=> (int) $value->ENCODEDBY,
			'encoded_date'		=> $value->ENCODEDDATE,
			'cce_name'			=> $value->CCENAME,
			'transact_type_id'	=> (int) $value->TRANSACTTYPEID,
			'total_amount'		=> (double) $value->TOTALAMOUNT,	
			'discount'			=> (double) $value->DISCOUNT,
			'net_amount'		=> (double) $value->NETAMOUNT,
			'customer'			=>[
									'id'   		 => $customerID,
									'name' 		 => $customerName,
									'mobile_num' =>$customerMobile	
								],
			'customer_name'		=> $value->CUSTOMERNAME,					
			'cellular_number'	=> $value->CELLULARNUMBER,
			'status'			=> $value->STATUS,
			'date_completed'	=> $value->DATECOMPLETED	
			];

			return $newData;
			
		});
		return $data;
	} 

	public function osHeader($data){
		$customer = Customer::where('CUSTOMERID',$data->CUSTOMERCODE)
								->where('BRANCHID', $data->BRANCHID)
								->first();
		if (is_null($customer)) {
			$customerID = NULL;
			$customerName = NULL;
			$customerMobile = NULL;
		}else{
			$customerID = $customer->CUSTOMERID;
			$customerName = $customer->NAME;
			// $customerMobile = $customer->mobile_number;
			$customerMobile = $customer->MOBILE_NUMBER;
		}
	
		$newData = [
			'branch_id' 		=> $data->BRANCHID, 
			'os_no' 			=> (int) $data->ORDERSLIPNO,
			'os_date' 			=> $data->OSDATE,
			'encoded_by'		=> (int) $data->ENCODEDBY,
			'encoded_date'		=> $data->ENCODEDDATE,
			'cce_name'			=> $data->CCENAME,
			'transact_type_id'	=> (int) $data->TRANSACTTYPEID,
			'total_amount'		=> (double) $data->TOTALAMOUNT,	
			'discount'			=> (double) $data->DISCOUNT,
			'net_amount'		=> (double) $data->NETAMOUNT,
			'customer'			=>[
									'id'   		 => $customerID,
									'name' 		 => $customerName,
									'mobile_num' => $customerMobile	
								],
			'customer_name'		=> $data->CUSTOMERNAME,				
			'cellular_number'	=> trim($data->CELLULARNUMBER),
			'status'			=> $data->STATUS,
			'date_completed'	=> $data->DATECOMPLETED	
		]; 
		return $newData; 
	} 


}