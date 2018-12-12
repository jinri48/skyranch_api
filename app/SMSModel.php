<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SMSModel extends Model
{
    //
    protected $table  			= 'Message'; 
    protected $connection 		= 'sqlsrvHODB';
     public $timestamps 			= false;
}
