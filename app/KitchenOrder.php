<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KitchenOrder extends Model
{
    protected $table  			= 'kitchen_orders'; 
    protected $connection 		= 'sqlsrvHODB';
   	public $timestamps 			= false;
}
