<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SitePart;	
use App\Transformer\SitePartTransformer;

class SitePartController extends Controller
{
    //

    public function index(Request $request){

    	//search_value 
    	$search_value = $request->get('search_value');

    	$sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
    					->paginate();

    	$spt = new SitePartTransformer;
    	$newData = $spt->siteParts($sitePart); 

    	return response()->json([
    		'success' 	=> true,
    		'status' 	=> 200,
    		'message' 	=> 'success',
    		'data' 		=> $newData
    	]);



    }

    public function getProductById(Request $request){
        //search_value 
        $search_id = $request->get('search_id');
        $sitePart = SitePart::where('PRODUCT_ID', $search_id)->first();

        $spt = new SitePartTransformer;
        $newData = $spt->sitePart($sitePart); 

        return response()->json([
            'success' => false,
            'status' => 200,
            'message' => 'success',
            'data' => $newData
        ]);
    }

}