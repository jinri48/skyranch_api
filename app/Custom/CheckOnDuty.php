<?php

namespace App\Custom;

use App\Clarion;
use App\CCEOnDuty;

/**
 * 
 */
class CheckOnDuty
{
	

	public static function cceOnDuty($number){
    	//check if on duty
        $c      = new Clarion;      
        $cce    = new CCEOnDuty;     
        
        $result = $cce->isOnDuty(trim($number), $c->today() );
        if(is_null($result) ){
            return false;	
        }  
        return $result;
    }
	

}