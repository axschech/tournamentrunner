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
		if(Session::has('logged'))
		{
			return Redirect::to('/logged');
		}
		else
		{
			return View::make('initializr.index');
		}
	}

	public function postLogin()
	{
		$input = Input::all();
		$missing = array();

		if($input)
		{
			foreach($input as $key=>$val)
			{
				if($val=="")
				{
					$missing[] = $key;
				}
			}
			if(count($missing)>0)
			{
				return json_encode(array("error"=>$missing));
			}
			else
			{
				$res = User::where('email',$input['email'])->get()->first();
				if(!empty($res))
				{
					if(Hash::check($input['password'], $res->password))
					{
						Session::put('logged',$res->id);

						return json_encode(array("error"=>array()));
					}
					else
					{
						return json_encode(array("error"=>array("Wrong Email / Password")));
					}
				}
				else
				{
					return json_encode(array("error"=>array("Wrong Email / Password")));
				}
			}
		}
	}

	public function postRegister()
	{
		$input = Input::all();
		$missing = array();

		if($input)
		{
			foreach($input as $key=>$val)
			{
				if($val=="")
				{
					$missing[] = $key;
				}
			}
			if(count($missing)>0)
			{
				return json_encode(array("error"=>$missing));
			}
			else
			{
				$user = User::where('email',$input['email'])->get()->first();
				if(empty($user))
				{
					$theUser = new User();

					foreach($input as $key=>$val)
					{
						if($key=="password")
						{
							$theUser->$key = Hash::make($val);
						}
						else
						{
							$theUser->$key = $val;
						}
					}
					$theUser->save();

					Session::put('logged',$theUser->id);

					return json_encode(array("error"=>array()));
				}
				else
				{
					return json_encode(array("error"=>array('exists')));
				}
			}
		}
	}
	

}
