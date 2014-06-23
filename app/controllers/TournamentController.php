<?php

class TournamentController extends BaseController {

	public function getIndex($id)
	{

		$user = User::find(Session::get('logged'))->toArray();

		$tournament = Tournament::find($id);

		$tournament->getTournament();

		
		return View::make('tournament',array('tournament'=>json_encode($tournament->toArray()),"players"=>json_encode($tournament->players),"user"=>json_encode($user['name'])));
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
			// $tournament->active=1;
			$tournament->user = Session::get('logged');

			$tournament->save();
			$id = $tournament->id;
			$o = 1;
			foreach(json_decode($input['players']) as $item)
			{
				$player = new Player();
				$player->name = $item;
				$player->tournament = $id;
				$player->place = 0;
				$player->game = 0;
				$player->score = 0;
				$player->order = $o;
				$o++;

				$player->save();
			}
			return json_encode(array("error"=>array(),"id"=>array($id)));
		}
		else
		{
			return  json_encode(array("error"=>array("That tournament already exists!")));
		}
	}

	public function putIndex($id)
	{
		$tournament = Tournament::find($id);
		$res = $tournament->nextGame();
		if($tournament)
		{
			$tournament->getTournament();
			return json_encode(array('error'=>array(),'tournament'=>$res,'players'=>$tournament->players));
		}
	}

	public function deleteIndex($id)
	{
		$tournament = Tournament::find($id);

		$res = $tournament->deleteTournament();

		
		if($res==1)
		{
			$tournaments = array();

			$res = Tournament::where('user',Session::get('logged'))->get();
			if(!empty($res))
			{
				foreach($res as $item)
				{
					$tournaments[] = $item->toArray();
				}
			}
			else
			{
				$tournaments = array();
			}
			
			return json_encode(array('error'=>array(),'tournaments'=>$tournaments));
		}
		else
		{
			return json_encode(array('error'=>array('Tournament not found')));
		}
	}


	public function postGame($id)
	{
		$tournament = Tournament::find($id);
		if(!empty($tournament))
		{
			$res = $tournament->startTournament();
			$tournament->getTournament();
			return json_encode(array('error'=>array(),'game'=>array($res),'players'=>array($tournament->players),'active'=>array($tournament->active)));
		}
		else
		{
			return json_encode(array('error'=>array('Tournament not found')));
		}
	}

	public function putGame($id)
	{
		$input = Input::all();
		$scored = array();

		$tournament = Tournament::find($id);

		if($tournament->active==0)
		{
			return json_encode(array('error'=>array('active'=>false)));
			die();
		}

		foreach($input['data'] as $key=>$val)
		{
			$player = Player::find($key);
			if($player->scored)
			{
				$scored[] = $player->name;
				continue;
			}
			else
			{
				$player->score+=$val;
				$player->curScore = $val;
				$player->scored=1;
				$player->save();
			}
		}
		$done = $tournament->checkDone();
		$tournament->getTournament();

		if(count($scored)>0)
		{
			return json_encode(array('error'=>array('scored'=>$scored)));
		}
		else
		{
			return json_encode(array('error'=>array(),'players'=>$tournament->players, 'done'=>$done));
		}
		
		
	}

	public function getPlayers($id)
	{

		$tournament = Tournament::find($id);
		if(!empty($tournament))
		{
			$tournament->getTournament();
			$check = Input::get('check',false);
			if($check)
			{
				shuffle($tournament->players);
				$o = 1;
				foreach($tournament->players as $item)
				{
					$player = Player::find($item['id']);
					$player->order = $o;
					$player->save();
					$o++;
				}
			}
			return json_encode(array('error'=>array(), "players"=>array($tournament->players),"active"=>array($tournament->active)));
		}
		else
		{
			return json_encode(array("error"=>array("Tournament not found")));
		}
		
		
	}

}