<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Clarion extends Model
{
    //
	protected $start_date =	'1801-01-01';

	public function today(){
		$start = Carbon::parse($this->start_date);
		$now = Carbon::now(); 
		
		$dateDiff = $now->diffInDays($start) + 4;
		return $dateDiff;
	}
}
