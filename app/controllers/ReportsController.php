<?php


/**
 * this class is the default controller of our application,
 * 
*/
class ReportsController extends controller
{


	public function __construct(){

	}






	public function weekly($from=null, $to=null)
	{
		

		$query =  $this->auth()->earnings();
		if (($from != null) && ($to != null)) {
			$query =  $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
		}

		$earnings = $query->get();
		$earnings_total = $query->sum('amount_earned');
		$this->view('auth/weekly-report', [
											'earnings'=>$earnings,
											'earnings_total'=>$earnings_total,
											]);
	}
	
	




	public function monthly($from=null, $to=null)
	{
		$query =  $this->auth()->earnings();
		if (($from != null) && ($to != null)) {
			$query =  $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
		}

		$earnings = $query->get();
		$earnings_total = $query->sum('amount_earned');
		$this->view('auth/monthly-report', [
											'earnings'=>$earnings,
											'earnings_total'=>$earnings_total,
											'from'=>$from,
											'to'=>$to,
											]);
	}





	public function income($from=null, $to=null)
	{
		$query =  $this->auth()->earnings();
		if (($from != null) && ($to != null)) {
			$query =  $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
		}

		$earnings = $query->get();
		$earnings_total = $query->sum('amount_earned');
		$this->view('auth/income-report', [
											'earnings'=>$earnings,
											'earnings_total'=>$earnings_total,
											'from'=>$from,
											'to'=>$to,
											]);
	}



	public function withdrawals($from=null, $to=null)
	{
		$query =  $this->auth()->withdrawals();
		if (($from != null) && ($to != null)) {
			$query =  $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
		}

		$withdrawals = $query->get();
		$withdrawals_total = $query->sum('amount_earned');
		$this->view('auth/withdrawal-history', [
											'withdrawals'=>$withdrawals,
											'withdrawals_total'=>$withdrawals_total,
											'from'=>$from,
											'to'=>$to,
											]);
	
	}



	public function withdrawal_request()
	 {
	 	print_r(Input::all());
	 	$amount =  Input::get('amount');
	 	if ($amount > $this->auth()->available_balance()) {
	 		Session::putFlash('', 'Invalid withdrawal request');
	 		Redirect::to('report/withdrawals/');
	 	}

	 	LevelIncomeReport::create([
							'owner_user_id'	=> $this->auth()->id,
							'amount_earned'	=> $amount,
							'status'		=> 'Debit',
							'commission_type'=> 'Withdrawal',
							'availability'	=> 1,
							]);

	Session::putFlash('', 'Withdrawal request successful');
	 		Redirect::to('report/withdrawals/');

	 } 


	public function index()
	{


	}




}























?>