<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLastIssuedNumber extends Model
{

    protected $connection 		= 'sqlsrvHODB';  
    protected $table 			= 'branch_last_issued_numbers';

    
    public static function findByBranch($id){
    	return static::where('branch_id',$id)->first();
    }

    
}
