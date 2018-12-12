<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
   	protected $table  			= 'Customers'; 
    protected $connection 		= 'sqlsrvHODB';


    public function user(){
    	return $this->belongsTo('App\WebUser','user_id');
    }

    
}
