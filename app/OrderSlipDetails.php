<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderSlipDetails extends Model
{
    //
    protected $table  			= 'OrderSLipDetails'; 
    protected $connection 		= 'sqlsrvHODB';
    public $timestamps 			= false;
}
