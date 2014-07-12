<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::controller('tournaments','TournamentsController');
Route::post('logout',function(){
	Session::flush();
	$cookie = Cookie::forget('logged');
	
	return Redirect::to('/login')->withCookie($cookie);
});


Route::controller('tournament/{name?}','TournamentController');

Route::controller('/login', 'HomeController');

Route::controller('/','LoggedController');

Route::filter('no', function($route)
{
	if(!Session::has('logged'))
	{
		$message = "<h1>Not Authorized, go <a href='/'>home</a>?</h1>";
		return Response::make($message,401);
	}

  	$id = $route->getParameter('name');
  	$check = false;
  	if(!empty($id))
  	{
  		$tournament = Tournament::find($id);
      //done make done view?
  		if($tournament)
  		{
  			$user = $tournament->user;
  			if($user==Session::get('logged'))
  			{
  				$check = true;
  			}
  		}
  	}
  	else
  	{
  		$check = true;
  	}

  	if(!$check)
  	{
  		$message = "<h1>Not Authorized, go <a href='/'>home</a>?</h1>";
		return Response::make($message,401);
  	}

  	
});



?>