<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Hash;

class UserSite extends Model
{
    //
    protected $table  			= 'UserSite';
    protected $primaryKey		= 'ID';
    protected $connection 		= 'sqlsrvSiteDB';
    public $timestamps 			= false;
 
    //logic 
    public static function newToken($num){
    	$salting  = 'randomshit';
    	return Hash::make($num.$salting);
    }

    public static function findByNumber($num){
    	return static::where('Number',$num)->first();
    }

    public static function findByToken($token){
        return static::where('TOKEN',$token)->first();
    }
}
