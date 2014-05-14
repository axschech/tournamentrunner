<?php

class TournamentController extends BaseController {

	public function getIndex($id)
	{
		$tournament = Tournament::find($id);
		$playerRes = Player::where('tournament',$tournament->id)->get();
		$players = array();
		foreach($playerRes as $item)
		{
			$players[] = $item->toArray();
		}
		return View::make('tournament',array('tournament'=>$tournament->toArray(),"players"=>$players));
	}

	public function postIndex()
	{
		$input = Input::all();
		$playersCount = count($input['players']);

		$check = Tournament::where('name',$input['title'])->get();
		
		if(empty($check[0]))
		{
			$tournament = new Tournament();

			$tournament->players = $playersCount;
			$tournament->name = $input['title'];
			$tournament->active=1;
			$tournament->user = Session::get('logged');

			$tournament->save();
			$id = $tournament->id;

			foreach(json_decode($input['players']) as $item)
			{
				$player = new Player();
				$player->name = $item;
				$player->tournament = $id;
				$player->place = 0;
				$player->game = 0;
				$player->score = 0;

				$player->save();
			}
			return json_encode(array("error"=>array(),"id"=>array($id)));
		}
		else
		{
			return  json_encode(array("error"=>array("That tournament already exists!")));
		}
		

		exit;
	}
}