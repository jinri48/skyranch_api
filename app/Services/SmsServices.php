<?php 

namespace App\Services;
use Log;
use App\SMSModel;

class SmsServices {

	public function welcomeMessage($number){

		try{

			//welcome message goes here
			$message = 'Welcome to Enchanted Kingdom! You may now load up your wallet to purchase anything from the store. Enjoy!';

			// save to the selected model for messaging.	
			Log::debug('recepient: '.$number.', message: '.$message);
			// SMSModel::create([
			// 	'Number' 	=> $number,
			// 	'message'	=> $message
			// ]);
			$sms = new SMSModel();
			$sms->Number = $number;
			$sms->Message = $message;
			$sms->save();
			// dd($sms);
			return true;

		}catch(\Exception $e){
			return false;
		}


	}
}