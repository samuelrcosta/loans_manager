<?php
function entry_color(\App\Entry $entry){
	$t_positive = true;
	if($entry->task->type == 'debt'){
		$t_positive = false;
	}
	$e_postive = true;
	if($entry->type == 0){
		$e_postive = false;
	}

	if($t_positive && $e_postive){
		return 'text-success';
	}else if($t_positive && !$e_postive){
		return 'text-danger';
	}else if(!$t_positive && $e_postive){
		return 'text-danger';
	}else if(!$t_positive && !$e_postive){
		return 'text-success';
	}else{
		return '';
	}
}

function task_color(\App\Task $task){
	if($task->type == 'income'){
		return 'text-success';
	}else{
		return 'text-danger';
	}
}