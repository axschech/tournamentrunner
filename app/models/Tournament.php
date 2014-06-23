<?php

class Tournament extends Eloquent {

	protected $table = 'tournaments';

	public $timestamps = false;

	public $players;

	public function getTournament($id="")
	{
		$players = Player::where('tournament',$this->id)->get()->toArray();
		 usort($players, function($a, $b){
                    return ($a['order'] < $b['order']) ? -1 : 1;
                });
		$this->players = $players;
	}

	public function startTournament($id="")
	{
		$this->getTournament();
		$this->active = 1;
		$this->game++;
		$this->save();

		$res = "";

		if($this->players)
		{
			$pids = array();
			foreach($this->players as $item)
			{
				$pids[] = $item['id'];
			}
			$pStr = implode(', ', $pids);
			$query = "UPDATE players SET game=".$this->game." WHERE tournament=".$this->id;

			$res = DB::statement($query);
		}
		if($res)
		{
			return $this->game;
		}
		else
		{
			return false;
		}
	}

	public function deleteTournament($id="")
	{

		$pRes = Player::where('tournament',$this->id)->delete();

		$res = Tournament::destroy($this->id);
		return $res;
	}

	public function checkDone($id="")
	{
		$this->getTournament();
		$nope = false;
		foreach($this->players as $item)
		{
			if($item['scored']==0)
			{
				$nope = true;
				break;
			}
		}
		if($nope)
		{
			$this->roundDone = 0;
			$this->save();
			return false;
		}
		else
		{
			$this->roundDone = 1;
			$this->save();
			return true;
		}

	}

	public function nextGame($id="")
	{
		$this->getTournament();
		foreach($this->players as $item)
		{
			$player = Player::find($item['id']);
			$player->scored = 0;
			$player->curScore = 0;
			$player->game++;
			$player->order = $player->score;
			$player->save();
		}
		$this->roundDone = 0;
		$this->game++;
		$this->save();
		
		$retArray = $this->toArray();

		$retArray['players'] = $this->players;
		return $retArray;
	}
}
		
?>