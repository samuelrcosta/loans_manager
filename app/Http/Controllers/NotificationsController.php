<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Config;
use App\Alert;

class NotificationsController extends Controller
{
	private $data = array();

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {  }

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index(Request $request)
	{
		$code = Config::getByKey('notifications_code');
		if($code){
			$code = $code->value;
		}else{
			$code = null;
		}
		$req = Input::get('code');

		if($code == $req){
			$this->sendNotifications();
			echo "OK";
		}else{
			echo "Error";
		}
	}

	public function sendNotifications(){
		$a = new Alert();
		$alerts = $a->getCurrentAlerts();

		if($alerts->isEmpty()){
			echo "No Alerts";
			return;
		}

		foreach ($alerts as $alert){
			echo $alert->title." - date: ".$alert->date." - repeat: ".$alert->repeats.'<br>';
		}
	}
}