<?php

class Tournament extends Eloquent {

	protected $table = 'tournaments';

	

	public $timestamps = false;

	public $players;

	public function getTournament($id="")
	{
		$this->players = Player::where('tournament',$this->id)->get()->toArray();
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
}

?>