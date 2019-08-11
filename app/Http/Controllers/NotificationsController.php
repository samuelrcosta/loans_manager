<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
use Mail;
use App\Config;
use App\Alert;
use App\Subscription as AppSubscription;

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
			$this->sendEmail($alert);
			$this->sendPushAlert($alert);
			echo '<br>'.$alert->title." - date: ".$alert->date." - repeat: ".$alert->repeats.'<br>';
		}
	}

	private function sendEmail(\App\Alert $alert){
		$user = $alert->user;
		$emailSubject = $alert->title." - Loans Manager";
		$emailView = 'notifications.email';
		$emailContent = array('alert' => $alert);

		try{
			Mail::send($emailView, $emailContent, function ($mail) use ($user, $emailSubject) {
				$mail->from(env('MAIL_USERNAME'), 'Loans Manager');
				$mail->to($user->email, $user->name)->subject($emailSubject);
			});
		}catch (\Exception $e){
			echo $e->getMessage();
		}
	}

	private function sendPushAlert(\App\Alert $alert){
		$subscriptions = AppSubscription::getByUserId($alert->user_id);
		if($subscriptions->isNotEmpty()){
			$notifications = array();
			// Add all subs on array
			foreach($subscriptions as $sub){
				$notifications[] = ['subscription' => Subscription::create(json_decode($sub->data, true))];
			}
			// Auth object
			$auth = [
				'VAPID' => [
					'subject' => env('APP_URL'), // can be a mailto: or your website address
					'publicKey' => env('PUSH_NOTIFICATIONS_PUBLIC_KEY'),
					'privateKey' => env('PUSH_NOTIFICATIONS_PRIVATE_KEY')
				],
			];

			$webPush = new WebPush($auth);

			$message = array(
				'title' => $alert->title." - Loans Manager",
				'body' => $alert->comments,
				'icon' => env('APP_URL').'/img/logo.jpg',
				'badge' => env('APP_URL').'/img/logo.jpg',
				'uri' => env('APP_URL')
			);

			// send multiple notifications
			foreach ($notifications as $notification) {
				$webPush->sendNotification(
					$notification['subscription'],
					json_encode($message)
				);
			}

			//Check sent results
			foreach ($webPush->flush() as $report) {
				$endpoint = $report->getRequest()->getUri()->__toString();

				if ($report->isSuccess()) {
					echo "<br><br>[v] Message sent successfully for subscription {$endpoint}.";
				} else {
					echo "<br><br>[x] Message failed to sent for subscription {$endpoint}: {$report->getReason()}";
				}
			}
		}

	}
}