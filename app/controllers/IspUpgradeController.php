<?php
// error_reporting(E_ERROR | E_PARSE);

use Illuminate\Database\Capsule\Manager as DB;

/**



*/
class IspUpgradeController extends controller
{


	public function set_users_positions()
	{

		$users = User::all();

		foreach ($users as $user ) {
			$user->setTreesPosition();
		}
		
	}

}
















?>