<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Subscription extends Model
{
	use SoftDeletes;
	protected $table = 'subscriptions';

	public function user(){
		return $this->belongsTo('App\User');
	}

	public static function findByFingerprint($fingerprint){
		return Subscription::where('fingerprint', $fingerprint)->first();
	}

	public static function getByUserId($user_id){
		return Subscription::where('user_id', $user_id)->where('status', 1)->get();
	}
}
