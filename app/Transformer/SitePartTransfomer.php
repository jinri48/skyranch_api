<?php

namespace App\Transformer;

class SitePartTransformer{

	public function siteParts($data){
		
		$data->getCollection()->transform(function ($value){
			
			$url = config('app.main_api_url').$value->IMAGE;
			$newData = [
			'arnoc' 		=> $value->ARNOC, 
			'product_id' 	=> $value->PRODUCT_ID,
			'product_name' 	=> trim($value->DESCRIPTION),
			'group'			=> trim($value->GROUP),
			'category'		=> $value->CATEGORY,
			'part_no'		=> trim($value->PARTNO),
			'status'		=> $value->STATUS,	
			'retail_price'	=> $value->RETAIL,
			'img_url'		=> $url,
			'location'		=> (int) $value->PRODGRP,
			'parts_type'	=> trim($value->PARTSTYPE),
			'post_mix'		=> (int) $value->POSTMIX,
			'components'	=> $value->components->transform( function($v) {	// sitepart
									return [
										'component_id'	=> trim($v->PARTSID),
										'component_desc' => trim($v->DESCRIPTION),
										'qty'			=> $v->QUANTITY,
										'modifiable'	=> (int) $v->MODIFIABLE,
										'is_free'		=> (int) $v->ISFREE,
										'comp_cat'		=> (int) $v->COMPCATID,
										'location'		=> (int) $v->componentDetail->PRODGRP,
										'retail_price'  => $v->componentDetail->RETAIL,
										'extended_cost' => $v->EXTENDCOSTC,
										'img_url'		=> config('app.main_api_url')
															.$v->componentDetail->IMAGE
									];
								})

					 
			];
			//'location'	=> $v->PRODGRP // location

			return $newData;
			//return $value;
		});
		return $data;
	}


	public function sitePart($data){ 

		$newData = [
			'arnoc' 		=> (int) $data->ARNOC, 
			'product_id' 	=> (int) $data->PRODUCT_ID,
			'product_name' 	=> trim($data->DESCRIPTION),
			'group'			=> $data->GROUP,
			'category'		=> $data->CATEGORY,
			'part_no'		=> trim($data->PARTNO),
			'status'		=> $data->STATUS,	
			'retail_price'	=> number_format((float)$data->RETAIL, 2, '.', ''),
			'img_url' 		=> $data->IMG_URL
		]; 
		return $newData; 
	}


	public function component($data){

		$data->map(function ($value, $key){
			
			$newData = [
				'comp_pro_id' 	=>$value->PRODUCT_ID,
				'comp_id' 		=>$value->PARTSID,
				'comp_desc'		=>$value->DESCRIPTION,
				'qty' 			=>$value->QUANTITY,
				'extended_cost' =>$value->EXTENDCOSTC,
				'modifiable' 	=>$value->MODIFIABLE,
				'is_free' 		=>$value->ISFREE,
				'comp_id' 		=>$value->COMPCATID,
				
			];
			return $newData;
		});


	}
}