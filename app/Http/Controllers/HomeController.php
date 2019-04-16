<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	private $data = array();
	const LOCAL = 'dashboard';
	const PAGE_NAME = 'Dashboard';

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
        return view('home/index', $this->data);
    }
}
