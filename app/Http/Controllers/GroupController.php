<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class GroupController extends Controller
{
    public function index(){
    		
    	$product_groups = Group::
    		whereNotIn("GROUPCODE", array(12,13))
    		->get();

    	return response()->json([
    		'success' => "true",
    		'status'  => 200,
    		'data'	 => $product_groups
    	]);
    }
}
