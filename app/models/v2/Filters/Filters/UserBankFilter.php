<?php


namespace Filters\Filters;
use Filters\QueryFilter;
use User ;
use v2\Models\FinancialBank ;

use Filters\Traits\RangeFilterable;

/**
 * 
 */
class UserBankFilter extends QueryFilter
{
	use RangeFilterable;

	public function firstname($firstname = null)
	{
		if ($firstname == null) {
			return ;
		}
		$user_ids = User::where('firstname', "like",  "%$firstname%")->get()->pluck('id')->toArray();

		$this->builder->whereIn('user_id', $user_ids);


	}


	public function bank_id($bank_id)
	{
		
		if ($bank_id == null) {
				return ;
			}

			$bank_ids = FinancialBank::where('id', "$bank_id")->get()->pluck('id')->toArray();

		$this->builder->whereIn('bank_id', $bank_ids);
	}

	public function status($status)
	{

		if ($status == null) {
				return ;
			}
		$this->builder->where('status', $status);
	}


	public function account_number($account_number = null)
	{
		if ($account_number == null) {
			return ;
		}

		$this->builder->where('account_number', $account_number);
	}




	public function lastname($lastname = null)
	{
		if ($lastname == null) {
			return ;
		}

		$user_ids = User::where('lastname', "like",  "%$lastname%")->get()->pluck('id')->toArray();

		$this->builder->whereIn('user_id', $user_ids);

	}


	public function email($email = null)
	{
		if ($email == null) {
			return ;
		}

		$user_ids = User::where('email', $email)->get()->pluck('id')->toArray();

		$this->builder->whereIn('user_id', $user_ids);
	}

	public function name($name = null)
	{
		if ($name == null) {
			return ;
		}

		$user_ids = User::WhereRaw("firstname like ? 
                                      OR lastname like ? 
                                      OR middlename like ? 
                                      OR username like ? 
                                      OR email like ? 
                                      OR phone like ? 
                                      ",
                                      array(
                                          '%'.$name.'%',
                                          '%'.$name.'%',
                                          '%'.$name.'%',
                                          '%'.$name.'%',
                                          '%'.$name.'%',
                                          '%'.$name.'%')
                                  )->get()->pluck('id')->toArray();



		$this->builder->whereIn('user_id', $user_ids);
	}



	public function phone($phone = null)
	{
		if ($phone == null) {
			return ;
		}

		$user_ids = User::where('phone', $phone)->get()->pluck('id')->toArray();

		$this->builder->whereIn('user_id', $user_ids);
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