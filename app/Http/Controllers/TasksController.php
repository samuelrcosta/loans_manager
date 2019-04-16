<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TasksController extends Controller
{
	private $data = array();
	const LOCAL = 'tasks';
	const PAGE_NAME = 'Tasks';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
		$this->data["LOCAL"] = self::LOCAL;
		$this->data["PAGE_NAME"] = self::PAGE_NAME;
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index(Request $request)
	{
		return view('tasks/index', $this->data);
	}
}
