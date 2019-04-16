<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Contact;

class ContactsController extends Controller
{
	private $data = array();
	const LOCAL = 'contacts';
	const PAGE_NAME = 'Contacts';

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
		$this->data['list'] = Contact::all();
		return view('contacts/index', $this->data);
	}

	public function create(Request $request)
	{
		return view('contacts/form', $this->data);
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|max:150',
			'nickname' => 'nullable|max:100',
			'email' => 'nullable|email|max:150',
			'phone' => 'nullable|max:45',
			'phone_2' => 'nullable|max:45',
			'comments' => 'nullable'
		]);

		$contact = new Contact();
		$contact->user_id = Auth::id();
		$contact->name = $request->name;
		$contact->nickname = $request->nickname;
		$contact->email = $request->email;
		$contact->phone = $request->phone;
		$contact->phone_2 = $request->phone_2;
		$contact->comments = $request->comments;

		try{
			$contact->save();
			return redirect()->route('contacts@edit', ['id' => $contact->id])->with('responseSuccess', 'Contact created successfully!');
		}catch(\Exception $e){
			return redirect()->route('contacts@create')->with('responseError', 'An error has occurred');
		}
	}

	public function edit(Request $request)
	{
		$id = (int)$request->id;

		$contact = Contact::find($id);

		if(!$contact){
			return redirect()->route('contacts')->with('responseError', 'Contact not found');
		}

		$this->data['data'] = $contact;
		return view('contacts/form', $this->data);
	}

	public function update(Request $request)
	{
		$id = (int)$request->id;

		$contact = Contact::find($id);

		if(!$contact){
			return redirect()->route('contacts')->with('responseError', 'Contact not found');
		}

		$request->validate([
			'name' => 'required|max:150',
			'nickname' => 'nullable|max:100',
			'email' => 'nullable|email|max:150',
			'phone' => 'nullable|max:45',
			'phone_2' => 'nullable|max:45',
			'comments' => 'nullable'
		]);

		$contact->name = $request->name;
		$contact->nickname = $request->nickname;
		$contact->email = $request->email;
		$contact->phone = $request->phone;
		$contact->phone_2 = $request->phone_2;
		$contact->comments = $request->comments;

		try{
			$contact->save();
			return redirect()->route('contacts@edit', ['id' => $contact->id])->with('responseSuccess', 'Contact modified successfully!');
		}catch(\Exception $e){
			return redirect()->route('contacts@edit', ['id' => $contact->id])->with('responseError', 'An error has occurred');
		}
	}

	public function destroy(Request $request){
		$id = (int)$request->id;

		$contact = Contact::find($id);

		if(!$contact){
			return redirect()->route('contacts')->with('responseError', 'Contact not found');
		}

		try{
			$contact->delete();
			return redirect()->route('contacts')->with('responseSuccess', 'Contact deleted successfully!');
		}catch(\Exception $e){
			return redirect()->route('contacts', ['id' => $contact->id])->with('responseError', 'An error has occurred');
		}
	}
}
