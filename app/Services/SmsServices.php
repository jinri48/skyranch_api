<?php 

namespace App\Services;
use Log;

class SmsServices {

	public function welcomeMessage($number){

		try{

			//welcome message goes here
			$message = 'Welcome to Enchanted Kingdom! You are now a Loyalty Member. You may now load up your wallet to purchase anything from the store and earn a points for every purchase. Enjoy!';

			// save to the selected model for messaging.
			Log::debug('recepient: '.$number.', message: '.$message);
			//\App\SmsModel::create([
			// 'number' 	=> $number,
			// 'message'	=> $message
			//]);

			return true;

		}catch(\Exception $e){
			return false;
		}


	}
}