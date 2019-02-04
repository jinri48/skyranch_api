<?php

/**
 * 
 */

use Illuminate\Http\Request;
use App\PostMix;

class PostMixController extends Controller
{
	
	function __construct(argument)
	{
	
	}

	public function getComponents(Request $request){

		$product_id = $request->pro_id;

		$postmix = PostMix::where('PRODUCT_ID', $product_id);
	}
	
	public function getComponentsOfCat(Request $request){

		$cat_id = $request->cat_id;

		$postmix = PostMix::where('COMPCATID', $cat_id);
		return response()->json([
			'success' => true,
			'status' => 200,
			
		]);

	}




}