<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
	protected $table = 'configs';

	public static function getByKey($key){
		return Config::where('key', $key)->first();
	}
}
