<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CCEOnDuty extends Model
{
    //
    protected $table  			= 'CCEOnDuty'; 
    protected $connection 		= 'sqlsrvHODB';
    public $timestamps 			= false;


    public function isOnDuty($num,$clarionToday){
    	return static::where('CCENUMBER',$num)
    				->where('DATE',$clarionToday)
    				->first();
    }
}
