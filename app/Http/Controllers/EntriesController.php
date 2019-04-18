<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Task;
use App\Entry;

class EntriesController extends Controller
{
	private $data = array();
	const LOCAL = 'entries';
	const PAGE_NAME = 'Entries';

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

	public function create(Request $request){
		$task_id = (int)$request->task_id;

		$task = Task::find($task_id);
		if(!$task){
			return redirect()->route('tasks')->with('responseError', 'Task not found');
		}

		$this->data['task'] = $task;
		return view('entries/form', $this->data);
	}

	public function store(Request $request)
	{
		$task_id = (int)$request->task_id;

		$task = Task::find($task_id);
		if(!$task){
			return redirect()->route('tasks')->with('responseError', 'Task not found');
		}

		$request->validate([
			'type' => ['required', 'numeric', Rule::in([0, 1])],
			'value' => 'required',
			'comments' => 'nullable'
		]);

		$entry = new Entry();
		$entry->task_id = $task->id;
		$entry->type = $request->type;
		$value = $request->value;
		$value = str_replace('.', '', $value);
		$value = str_replace(',', '.', $value);
		$entry->value = $value;
		$entry->comments = $request->comments;

		try{
			$entry->save();
			return redirect()->route('tasks@show', ['id' => $task->id])->with('responseSuccess', 'Entry created successfully!');
		}catch(\Exception $e){
			return redirect()->route('entries@create', ['task_id' => $task->id])->with('responseError', 'An error has occurred');
		}
	}

	public function edit(Request $request){
		$task_id = (int)$request->task_id;
		$id = (int)$request->id;

		$entry = Entry::findByTask($task_id, $id);
		if(!$entry){
			return redirect()->route('tasks')->with('responseError', 'Task not found');
		}

		$task = Task::find($task_id);

		$this->data['task'] = $task;
		$this->data['data'] = $entry;
		return view('entries/form', $this->data);
	}

	public function update(Request $request)
	{
		$task_id = (int)$request->task_id;
		$id = (int)$request->id;

		$entry = Entry::findByTask($task_id, $id);
		if(!$entry){
			return redirect()->route('tasks')->with('responseError', 'Task not found');
		}

		$request->validate([
			'type' => ['required', 'numeric', Rule::in([0, 1])],
			'value' => 'required',
			'comments' => 'nullable'
		]);

		$entry->type = $request->type;
		$value = $request->value;
		$value = str_replace('.', '', $value);
		$value = str_replace(',', '.', $value);
		$entry->value = $value;
		$entry->comments = $request->comments;

		try{
			$entry->save();
			return redirect()->route('tasks@show', ['id' => $task_id])->with('responseSuccess', 'Entry modified successfully!');
		}catch(\Exception $e){
			return redirect()->route('entries@edit', ['id' => $task_id, 'task_id' => $task_id])->with('responseError', 'An error has occurred');
		}
	}

	public function destroy(Request $request)
	{
		$task_id = (int)$request->task_id;
		$id = (int)$request->id;

		$entry = Entry::findByTask($task_id, $id);
		if(!$entry){
			return redirect()->route('tasks')->with('responseError', 'Task not found');
		}

		try{
			$entry->delete();
			return redirect()->route('tasks@show', ['id' => $task_id])->with('responseSuccess', 'Entry deleted successfully!');
		}catch(\Exception $e){
			return redirect()->route('tasks@show', ['id' => $task_id])->with('responseError', 'An error has occurred');
		}
	}
}
