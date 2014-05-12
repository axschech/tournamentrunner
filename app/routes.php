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
	return Redirect::to('/');
});

Route::controller('tournaments/{id}','TournamentsController');

Route::controller('logged','LoggedController');

Route::controller('/', 'HomeController');


?>