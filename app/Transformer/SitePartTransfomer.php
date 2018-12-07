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
			'group'			=> $value->GROUP,
			'category'		=> $value->CATEGORY,
			'part_no'		=> trim($value->PARTNO),
			'status'		=> $value->STATUS,	
			'retail_price'	=> $value->RETAIL,
			'img_url'		=> $url
			];

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
}