<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WebCustomers;

class WebCustomerController extends Controller
{

    public function index(Request $request){
        
    	//search_value 
    	$search_value = $request->get('search_value');

    	$sitePart = WebCustomers::where('full_name','LIKE', '%'.$search_value.'%')
    					->paginate();

    	return response()->json([
    		'success' 	=> true,
    		'status' 	=> 200,
    		'message' 	=> 'success',
    		'data' 		=> $sitePart
    	]);

    }
}
