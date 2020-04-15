<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use User, MIS ;
use Filters\Traits\RangeFilterable;



/**
 * 
 */
class UserFilter extends QueryFilter
{
	use RangeFilterable;



	public function month($month = null)
	{
		if ($month == null) {
			return ;
		}

		$date = MIS::date_range($month, 'month');

		$this->date($date, 'created_at');
	}

	public function id($id = null)
	{
		if ($id == null) {
			return ;
		}
		$this->builder->where('id', "like",  "%$id%");
	}

	public function firstname($firstname = null)
	{
		if ($firstname == null) {
			return ;
		}
		$this->builder->where('firstname', "like",  "%$firstname%");
	}

	public function lastname($lastname = null)
	{
		if ($lastname == null) {
			return ;
		}
		$this->builder->where('lastname', "like",  "%$lastname%");
	}


	public function middlename($middlename = null)
	{
		if ($middlename == null) {
			return ;
		}
		$this->builder->where('middlename', "like",  "%$middlename%");
	}



	public function country($country = null)
	{
		if ($country == null) {
			return ;
		}
		$this->builder->where('country', "like",  "%$country%");
	}

	
		
		public function name($name = null)
		{
			if ($name == null) {
				return ;
			}

			$user_ids = User::WhereRaw("firstname like ? 
	                                      OR lastname like ? 
	                                      OR username like ? 
	                                      OR email like ? 
	                                      OR phone like ? 
	                                      ",
	                                      array(
	                                          '%'.$name.'%',
	                                          '%'.$name.'%',
	                                          '%'.$name.'%',
	                                          '%'.$name.'%',
	                                          '%'.$name.'%')
	                                  )->get()->pluck('id')->toArray();



			$this->builder->whereIn('id', $user_ids);
		}



	public function email($email = null)
	{
		if ($email == null) {
			return ;
		}

		$this->builder->where('email', $email);
	}


	public function active_status($active_status = null)
	{
		if ($active_status == null) {
			return ;
		}

		$operations = [ 2 => '!=',  1 => '='];
		$operation = $operations[$active_status];
		
		$this->builder->where('blocked_on', $operation , null);
	}


	public function phone($phone = null)
	{
		if ($phone == null) {
			return ;
		}
		$this->builder->where('phone', $phone);
	}

	public function username($username = null)
	{
		if ($username == null) {
			return ;
		}
		$this->builder->where('username', $username);
	}


	public function registration($start_date=null , $end_date=null )
	{

		if (($start_date == null) &&  ($end_date == null) ) {
			return ;
		}

		$date = compact('start_date','end_date');

		if ($end_date == null) {
			$date = $start_date;
		}

		$this->date($date, 'created_at');
	}




}