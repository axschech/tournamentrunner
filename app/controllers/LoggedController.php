<?php

class LoggedController extends BaseController {

	public function getIndex()
	{
		if(Session::has('logged'))
		{
			$userid = Session::get('logged');

			$res = User::find($userid)->get();
			$user = $res[0]->toArray();

			$res = Tournaments::where('user',$userid)->get();

			$tournaments = array();

			foreach($res as $item)
			{
				$tournaments[] = $item->toArray();
			}

			// $res = Player::where('user',$userid)->get();

			return View::make('logged', array("user"=>$user,'tournaments'=>$tournaments));
		}
		else
		{
			return Redirect::to('/');
		}
	}

}

?>
