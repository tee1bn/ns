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

		$coinage_on = new Isp;
		$coinage_on->setUser($user)->doCheck();

		
		
	}





// ?pxmw?Lo}wMQ


}























?>