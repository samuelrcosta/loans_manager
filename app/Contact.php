<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Contact extends Model
{
	protected $table = 'contacts';
	public $timestamps = false;

	public function user(){
		return $this->belongsTo('App\User');
	}

	public static function find($id){
		return Contact::where('user_id', Auth::id())->where('id', $id)->first();
	}

	public static function all($columns = array()){
		return Contact::where('user_id', Auth::id())->orderBy('name', 'asc')->get();
	}
}
