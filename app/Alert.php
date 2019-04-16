<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
