<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Task;
use App\Contact;

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
		$tasks = Task::all();

		$this->data['list'] = $tasks;
		return view('tasks/index', $this->data);
	}

	public function show(Request $request)
	{
		$id = (int)$request->id;
		$task = Task::find($id);

		if(!$task){
			return redirect()->route('tasks')->with('responseError', 'Task not found');
		}

		$this->data['data'] = $task;

		return view('tasks/show', $this->data);
	}

	public function create(Request $request)
	{
		$this->data['contacts'] = Contact::all();

		return view('tasks/form', $this->data);
	}

	public function store(Request $request)
	{
		$request->validate([
			'contact' => 'nullable|numeric',
			'type' => ['required', Rule::in(['income', 'debt'])],
			'title' => 'required|max:255',
			'value' => 'required',
			'status' => ['required', 'numeric', Rule::in([0, 1])],
			'comments' => 'nullable'
		]);

		$task = new Task();
		$task->user_id = Auth::id();
		if($request->contact){
			$task->contact_id = $request->contact;
		}
		$task->type = $request->type;
		$task->title = $request->title;
		$value = $request->value;
		$value = str_replace('.', '', $value);
		$value = str_replace(',', '.', $value);
		$task->value = $value;
		$task->status = $request->status;
		$task->comments = $request->comments;

		try{
			$task->save();
			return redirect()->route('tasks@show', ['id' => $task->id])->with('responseSuccess', 'Task created successfully!');
		}catch(\Exception $e){
			return redirect()->route('tasks@create')->with('responseError', 'An error has occurred');
		}
	}

	public function edit(Request $request)
	{
		$id = (int)$request->id;
		$task = Task::find($id);

		if(!$task){
			return redirect()->route('tasks')->with('responseError', 'Task not found');
		}

		$this->data['data'] = $task;
		$this->data['contacts'] = Contact::all();

		return view('tasks/form', $this->data);
	}

	public function update(Request $request)
	{
		$id = (int)$request->id;
		$task = Task::find($id);

		if(!$task){
			return redirect()->route('tasks')->with('responseError', 'Task not found');
		}

		$request->validate([
			'contact' => 'nullable|numeric',
			'type' => ['required', Rule::in(['income', 'debt'])],
			'title' => 'required|max:255',
			'value' => 'required',
			'status' => ['required', 'numeric', Rule::in([0, 1])],
			'comments' => 'nullable'
		]);

		if($request->contact){
			$task->contact_id = $request->contact;
		}
		$task->type = $request->type;
		$task->title = $request->title;
		$value = $request->value;
		$value = str_replace('.', '', $value);
		$value = str_replace(',', '.', $value);
		$task->value = $value;
		$task->status = $request->status;
		$task->comments = $request->comments;

		try{
			$task->save();
			return redirect()->route('tasks@show', ['id' => $task->id])->with('responseSuccess', 'Task modified successfully!');
		}catch(\Exception $e){
			return redirect()->route('tasks@edit', ['id' => $task->id])->with('responseError', 'An error has occurred');
		}
	}

	public function updateStatus(Request $request){
		$id = (int)$request->id;
		$task = Task::find($id);

		if(!$task){
			return response(null, 404);
		}

		$request->validate([
			'status' => ['required', 'numeric', Rule::in([0, 1])]
		]);

		$task->status = $request->status;

		try{
			$task->save();
			return response(null, 200);
		}catch(\Exception $e){
			return response(null, 500);
		}
	}

	public function destroy(Request $request)
	{
		$id = (int)$request->id;
		$task = Task::find($id);

		if(!$task){
			return redirect()->route('tasks')->with('responseError', 'Task not found');
		}

		try{
			$task->delete();
			return redirect()->route('tasks')->with('responseSuccess', 'Task deleted successfully!');
		}catch(\Exception $e){
			return redirect()->route('tasks', ['id' => $task->id])->with('responseError', 'An error has occurred');
		}
	}
}
