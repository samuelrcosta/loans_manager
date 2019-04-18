<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
	use SoftDeletes;
	protected $table = 'tasks';

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function contact(){
		return $this->belongsTo('App\Contact');
	}

	public function entries(){
		return $this->hasMany('App\Entry');
	}

	public function alerts(){
		return $this->hasMany('App\Alert');
	}

	public function remaining(){
		$remaining = $this->value;
		foreach($this->entries as $item){
			if($this->type == 'income'){
				if($item->type == 1){
					$remaining -= $item->value;
				}else{
					$remaining += $item->value;
				}
			}else{
				if($item->type == 1){
					$remaining += $item->value;
				}else{
					$remaining -= $item->value;
				}
			}

		}
		return $remaining;
	}

	public static function find($id){
		return Task::where('user_id', Auth::id())->where('id', $id)->first();
	}

	public static function all($columns = array()){
		return Task::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
	}

	public static function selectList(){
		return Task::where('user_id', Auth::id())->orderBy('title', 'asc')->get();
	}
}
