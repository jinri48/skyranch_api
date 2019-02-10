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
<<<<<<< HEAD
                        ->orderBy('PRODUCT_ID','ASC')
=======
                        // ->orderBy('PRODUCT_ID','ASC')
>>>>>>> 53f3bd2f58055f2bb006515642285623316a1042
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
        $location = $request->get('location');

       // dd($request->get('page'),$request->get('arnoc'),$search_value);
        //?page=1,arnoc=1
        if (is_null($branch_id)) { // get all products
            $sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
<<<<<<< HEAD
               
=======
                // ->orderBy('PRODUCT_ID','DESC')
                ->where('STATUS', 'A')
                ->where('RETAIL', '>', 0)
>>>>>>> 53f3bd2f58055f2bb006515642285623316a1042
                ->Paginate();
        }else{ //get all products by branch

            if (is_null($product_group)) {
                $sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
                ->where('ARNOC', $branch_id)
<<<<<<< HEAD
=======
                ->where('STATUS', 'A')
                ->where('RETAIL', '>', 0)
                // ->orderBy('PRODUCT_ID','DESC')
>>>>>>> 53f3bd2f58055f2bb006515642285623316a1042
                ->Paginate();    
            }else{
                $sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
                ->where('ARNOC', $branch_id)
                ->where('GROUP', $product_group)
<<<<<<< HEAD
=======
                ->where('STATUS', 'A')
                ->where('RETAIL', '>', 0)
                // ->orderBy('PRODUCT_ID','DESC')
>>>>>>> 53f3bd2f58055f2bb006515642285623316a1042
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


    public function getProductsByLocBranch(Request $request){
        //search_value 
        $search_value = $request->get('search_value');
        $branch_id = $request->get('arnoc');
        $product_group = $request->get('group_cat');
        $location = $request->get('location');

       // dd($request->get('page'),$request->get('arnoc'),$search_value);
        //?page=1,arnoc=1
        
    
        if (is_null($location)) {
             return response()->json([
                'success' => "false",
                'status'  => 200,
                'message'   => "location is required"
            ]);
        }

        /*location 1 = admission / rides */
        if ($location == 1 && is_null($product_group)) {
            $sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
            ->where('ARNOC', $branch_id)
            ->whereIn('BSUNITCODE', array(103, 104))
            ->Paginate();
            
        }else if ($location == 1 && !is_null($product_group)) {
            $sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
            ->where('ARNOC', $branch_id)
            ->whereIn('BSUNITCODE', array(103, 104))
            ->where('GROUP', $product_group)
            ->Paginate();

        /*location 2 = food / restaurant*/
        }else if ($location == 2 && is_null($product_group)) {
            $sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
            ->where('ARNOC', $branch_id)
            ->whereIn('BSUNITCODE', array(102))
            ->where('RETAIL', '>', 0)
            ->Paginate();

        }else if ($location == 2 && !is_null($product_group)) {
            $sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
            ->where('ARNOC', $branch_id)
            ->whereIn('BSUNITCODE', array(102))
            ->where('GROUP', $product_group)
            ->Paginate();
        
         /*location 3 = souvenir / merchandise */
        } else if ($location == 3 && is_null($product_group)) {
             $sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
            ->where('ARNOC', $branch_id)
            ->whereIn('BSUNITCODE', array(101, 104))
            ->Paginate();

        }else if ($location == 3 && !is_null($product_group)) {
            $sitePart = SitePart::where('DESCRIPTION','LIKE', '%'.$search_value.'%')
            ->where('ARNOC', $branch_id)
            ->whereIn('BSUNITCODE', array(101, 104))
            ->where('GROUP', $product_group)
            ->Paginate();
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



}
