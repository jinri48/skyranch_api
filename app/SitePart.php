<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SitePart extends Model
{
    //
    protected $table  			= 'SiteParts'; 
    protected $connection 		= 'sqlsrvHODB';
    public $timestamps 			= false;

   	
   	// RELATIONSHIT

   	public function components(){
   		return $this->hasMany('App\PostMix','PRODUCT_ID','PRODUCT_ID');
   	}

   /* public function group(){
      return $this->hasOne('App\Group', 'GROUPCODE');
    }
*/

  	

}
