<?php

class TournamentsController extends BaseController {

	public function getIndex($id)
	{
		var_dump($id);
		exit;
	}

	public function postPlayer()
	{
		$input = Input::all();
		var_dump($input);
	}
}