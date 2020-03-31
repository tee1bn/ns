<?php

use v2\Models\Isp;

/**



*/
class RoutineController extends controller
{


	public function __construct(){

	}


	//
	public function coinage_on($user_id){

		$user = User::find($user_id);
/*
		$indirect_line = $user->referred_members_downlines(2, 'placement')[2];

		$indirect_line = $user->referred_members_downlines(2, 'placement')[2];
*/
		echo "<pre>";

		$coinage_on = new Isp;
		$coinage_on->setUser($user)->doCheck();
;
		
	}





// ?pxmw?Lo}wMQ


}























?>