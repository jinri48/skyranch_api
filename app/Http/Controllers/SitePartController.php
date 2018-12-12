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
                        ->orderBy('PRODUCT_ID','DESC')
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

    public function getProductsByBranch(Request $request){
        //search_value 
        $search_value = $request->get('search_value');
        $branch_id = $request->get('arnoc');
        $product_group = $request->get('group_cat');

        


       // dd($request->get('page'),$request->get('arnoc'),$search_value);
        //?page=1,arnoc=1
        if (is_null($branch_id)) { // get all products
            $sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
                ->orderBy('PRODUCT_ID','DESC')
                ->Paginate();
        }else{ //get all products by branch

            if (is_null($product_group)) {
                $sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
                ->where('ARNOC', $branch_id)
                ->orderBy('PRODUCT_ID','DESC')
                ->Paginate();    
            }else{
                $sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
                ->where('ARNOC', $branch_id)
                ->where('GROUP', $product_group)
                ->orderBy('PRODUCT_ID','DESC')
                ->Paginate();

            }
            
        }

        $spt = new SitePartTransformer;
        $newData = $spt->siteParts($sitePart); 

        return response()->json([
            'success'   => true,
            'status'    => 200,
            'message'   => 'success',
            'data'      => $newData
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
