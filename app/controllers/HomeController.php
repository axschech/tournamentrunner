<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/


	public function getIndex()
	{
		 return View::make('initializr.index');
	}

	public function postLogin()
	{
		$input = Input::all();
		var_dump($input);
	}
	// public function showWelcome()
	// {
	// 	return View::make('hello');
	// }

	// public function getTry()
	// {
	// 	$user = new User();

	// 	$test = User::where('username','Test2')->get()->first();
	// 	var_dump(is_null($test));
	// }
}
