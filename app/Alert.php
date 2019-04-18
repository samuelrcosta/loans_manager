<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Alert extends Model
{
	use SoftDeletes;
	protected $table = 'alerts';

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function task(){
		return $this->belongsTo('App\Task');
	}

	public static function find($id){
		return Alert::where('user_id', Auth::id())->where('id', $id)->first();
	}

	public static function all($columns = array()){
		return Alert::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
	}

	public function getCurrentAlerts(){
		$query = Alert::query();

		$query->where('status', 1);

		$query->where(function($query){
			$query->orWhere(function($query){
				$query->where('repeats', 0)->where('date', date('Y-m-d'));
			})->orWhere(function($query){
				$query->where('repeats', 1)->where('date', '<=', date('Y-m-d'))->where('repeat_day', date('d'));
			});
		});

		return $query->get();
	}
}
