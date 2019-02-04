<?php


namespace App;

use Illuminate\Database\Eloquent\Model;

class PostMix extends Model
{
    protected $table  			= 'Postmix'; 
    protected $connection 		= 'sqlsrvHODB';

    //RELATIONSHIT
    public function sitepart(){
    	return $this->belongsTo('App\SitePart','PRODUCT_ID');
    }
   
   public function componentDetail(){
   		return $this->belongsTo('App\SitePart','PARTSID','PRODUCT_ID');
   }
}