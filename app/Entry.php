<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
	use SoftDeletes;
	protected $table = 'entries';

	public function task(){
		return $this->belongsTo('App\Task');
	}

	public static function findByTask($task_id, $id){
		return Entry::where("task_id", $task_id)->where('id', $id)->first();
	}
}
