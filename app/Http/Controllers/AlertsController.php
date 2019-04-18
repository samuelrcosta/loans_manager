<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Task;
use App\Alert;

class AlertsController extends Controller
{
	private $data = array();
	const LOCAL = 'alerts';
	const PAGE_NAME = 'Alerts';

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
		$alerts = Alert::all();

		$this->data['list'] = $alerts;
		return view('alerts/index', $this->data);
	}

	public function create(Request $request)
	{
		$this->data['task_id'] = $request->task_id;
		$this->data['tasks'] = Task::selectList();

		return view('alerts/form', $this->data);
	}

	public function store(Request $request)
	{
		$request->validate([
			'task' => 'nullable|numeric',
			'title' => 'required|max:100',
			'comments' => 'nullable',
			'repeats' => ['required', 'numeric', Rule::in([0, 1])],
			'repeats_day' => 'nullable|numeric|max:31',
			'date' => 'required|date',
			'status' => ['required', 'numeric', Rule::in([0, 1])],
		]);

		$alert = new Alert();
		$alert->user_id = Auth::id();
		if(!empty($request->task)){
			$alert->task_id = $request->task;
		}
		$alert->user_id = Auth::id();
		$alert->title = $request->title;
		$alert->status = $request->status;
		$alert->comments = $request->comments;
		$alert->repeats = $request->repeats;
		$alert->repeat_day = $request->repeat_day;
		$alert->date = $request->date;

		try{
			$alert->save();
			if($alert->task){
				return redirect()->route('tasks@show', ['id' => $alert->task->id])->with('responseSuccess', 'Alert created successfully!');
			}else{
				return redirect()->route('alerts@edit', ['id' => $alert->id])->with('responseSuccess', 'Alert created successfully!');
			}
		}catch(\Exception $e){
			if($alert->task){
				return redirect()->route('tasks@show', ['id' => $alert->task->id])->with('responseError', 'An error has occurred');
			}else{
				return redirect()->route('alerts@create')->with('responseError', 'An error has occurred');
			}
		}
	}

	public function edit(Request $request)
	{
		$id = (int)$request->id;
		$alert = Alert::find($id);

		if(!$alert){
			return redirect()->route('alerts')->with('responseError', 'Alert not found');
		}

		$this->data['data'] = $alert;
		$this->data['task_id'] = Input::get('task_id');
		$this->data['tasks'] = Task::all();

		return view('alerts/form', $this->data);
	}

	public function update(Request $request)
	{
		$id = (int)$request->id;
		$alert = Alert::find($id);

		if(!$alert){
			return redirect()->route('alerts')->with('responseError', 'Alert not found');
		}

		$request->validate([
			'task' => 'nullable|numeric',
			'title' => 'required|max:100',
			'comments' => 'nullable',
			'repeats' => ['required', 'numeric', Rule::in([0, 1])],
			'repeats_day' => 'nullable|numeric|max:31',
			'date' => 'required|date',
			'status' => ['required', 'numeric', Rule::in([0, 1])],
		]);

		if(!empty($request->task)){
			$alert->task_id = $request->task;
		}
		$alert->title = $request->title;
		$alert->status = $request->status;
		$alert->comments = $request->comments;
		$alert->repeats = $request->repeats;
		$alert->repeat_day = $request->repeat_day;
		$alert->date = $request->date;

		try{
			$alert->save();
			if($alert->task){
				return redirect()->route('tasks@show', ['id' => $alert->task->id])->with('responseSuccess', 'Alert modified successfully!');
			}else{
				return redirect()->route('alerts@edit', ['id' => $alert->id])->with('responseSuccess', 'Alert modified successfully!');
			}

		}catch(\Exception $e){
			if($alert->task){
				return redirect()->route('tasks@show', ['id' => $alert->task->id])->with('responseError', 'An error has occurred');
			}else{
				return redirect()->route('alerts@edit', ['id' => $alert->id])->with('responseError', 'An error has occurred');
			}
		}
	}

	public function destroy(Request $request)
	{
		$id = (int)$request->id;
		$alert = Alert::find($id);

		if(!$alert){
			return redirect()->route('alerts')->with('responseError', 'Alert not found');
		}

		if($alert->task){
			$task = $alert->task;
		}else{
			$task = null;
		}

		try{
			$alert->delete();

			if($task){
				return redirect()->route('tasks@show', ['id' => $task->id])->with('responseSuccess', 'Alert deleted successfully!');
			}else{
				return redirect()->route('alerts')->with('responseSuccess', 'Alert deleted successfully!');
			}
		}catch(\Exception $e){
			if($task){
				return redirect()->route('tasks@show', ['id' => $task->id])->with('responseError', 'An error has occurred');
			}else{
				return redirect()->route('alerts', ['id' => $alert->id])->with('responseError', 'An error has occurred');
			}
		}
	}
}
