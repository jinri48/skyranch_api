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
Route::get('/siteparts',		'SitePartController@index')->middleware('isOnDuty'); 
Route::get('/sitepartsBranch', 	'SitePartController@getProductsByBranch')->middleware('isOnDuty'); 
Route::post('/getProductById', 	'SitePartController@getProductById')->middleware('isOnDuty');
Route::get('/getProductGroups', 'GroupController@index');

// ordering
Route::post('/addOrder', 		'OrderSlipHeaderController@insertOrder')->middleware('isOnDuty');

//customer
Route::get('/getCustomer', 		'CustomerController@searchCustomer')->middleware('isOnDuty');
Route::post('/phoneExist', 		'CustomerController@customerPhoneExists');

// parameters [ h:token, mobile_number, name, email, bday ]
Route::post('/newCustomer', 	'CustomerController@createNewCustomer')->middleware('isOnDuty'); 

 
//sales 
Route::post('/getSalesHistory', 'SalesHistoryController@getSalesHistory');
Route::post('/getSalesTotal', 	'SalesHistoryController@getSalesTotal');
<<<<<<< HEAD
//param[ header:token]
Route::post('/order-slip/header/{id}/details', 		'OrderSlipController@detailsPerHeader'); 


Route::get('/getGroups', 			'GroupController@groups');

// param [location] 
Route::get('/getGroupsLoc', 		'GroupController@groupsLoc');

/*all testing*/
Route::get('/onduty', 				'CCEOnDutyController@isOnDuty');
Route::post('/getSalesHistoryAll',	'SalesHistoryController@getSalesHistoryAll');
Route::get('/sitePartsLoc', 		'SitePartController@getProductsByLocBranch')->middleware('isOnDuty'); 


Route::get('/default', 'OrderSlipHeaderController@getClarionTime');

Route::post('/createNewFoodOrder', 'OrderSlipHeaderController@insertFoodOrder');
=======
Route::post('/order-slip/header/{id}/details', 		'OrderSlipController@detailsPerHeader'); //param[ header:token]


Route::get('/onduty', 'CCEOnDutyController@isOnDuty');
// Route::post('/getSalesHistoryAll', 	'SalesHistoryController@getSalesHistoryAll');
>>>>>>> 53f3bd2f58055f2bb006515642285623316a1042
