<?php

use Illuminate\Http\Request;
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token,Authorization');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: token');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// LOGIN
Route::post('/login', 				'LoginController@login'); //param( username, password )
// END OF LOGIN


// SAMPLE INAPP REQUEST
Route::post('/sample_test', function(Request $request){
	
	return response()->json([
		'success' 			=> true,
		'status' 			=> 200,
		'message' 			=> 'Success'
	]);

})->middleware('isOnDuty');


Route::post('/test',function(Request $request){

	$data = [
		'person' 	=> 'joserizal',
		'data' 		=> $request->myname
	];

	return response()->json([
		'data' 	=> $data
	]);
});

// Products or SiteParts
Route::get('/siteparts', 'SitePartController@index'); 

Route::post('/getProductById', 'SitePartController@getProductById');

Route::post('/addOrder', 'OrderSlipHeaderController@insertOrder');