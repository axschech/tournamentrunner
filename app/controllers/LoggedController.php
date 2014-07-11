<?php

class LoggedController extends BaseController {

	public function getIndex()
	{
		if(Session::has('logged'))
		{
			$userid = Session::get('logged');

			$res = User::find($userid)->get();
			$user = $res[0]->toArray();

			$res = Tournament::where('user',$userid)->get();

			$tournaments = array();

			foreach($res as $item)
			{
				$tournaments[] = $item->toArray();
			}

			// $res = Player::where('user',$userid)->get();

			return View::make('logged', array("user"=>json_encode($user),'tournaments'=>json_encode($tournaments)));
		}
		else
		{
			return Redirect::to('/login');
		}
	}

	public function getTournaments($id)
	{
		if(!Session::has('logged'))
		{
			return Response::make('Not Authorized',400);
		}
		$tournaments = array();
		$res = Tournament::where('user',$id)->get();
		foreach($res as $item)
		{
			$tournaments[] = $item->toArray();
		}
		if(count($tournaments)>0)
		{
			return json_encode(array('errors'=>array(),'tournaments'=>$tournaments));
		}
		else
		{
			return json_encode(array('errors'=>array('No tournaments found')));
		}
		exit;
	}

}

?>
