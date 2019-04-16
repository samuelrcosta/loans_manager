<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
