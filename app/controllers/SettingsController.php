<?php


/**
 * this class is the default controller of our application,
 * 
*/
class SettingsController extends controller
{


	public function __construct(){

	}





	//to pull from db with angularjs
	public function fetch_min_withrawal()
	{
		header("content-type:application/json");
	echo (SiteSettings::where('criteria', 'min_withrawal')->first()->settings );
	}


	public function update_min_withrawal()
	{			
			print_r($_POST);

			SiteSettings::where('criteria', 'min_withrawal')->first()
			->update(['settings'=> $_POST['content'] ]);
			Session::putFlash('success','Minimium Withdrawal Updated Successfully!');
	}
	




	//to pull from db with angularjs
	public function fetch_payments_timeout()
	{
		header("content-type:application/json");
	echo (SiteSettings::where('criteria', 'payments_timeout')->first()->settings );
	}


	public function update_payments_timeout()
	{			
			print_r($_POST);

			SiteSettings::where('criteria', 'payments_timeout')->first()
			->update(['settings'=> $_POST['content'] ]);
			Session::putFlash('success','Payment Timeout Updated Successfully!');
	}
	

	//to pull from db with angularjs
	public function fetch_site_settings()
	{
		header("content-type:application/json");
	echo (SiteSettings::where('criteria', 'site_settings')->first()->settings );
	}


	public function update_site_settings()
	{			
			print_r($_POST);

			SiteSettings::where('criteria', 'site_settings')->first()
			->update(['settings'=> $_POST['content'] ]);
			Session::putFlash('success','Settings Updated Successfully!');
	}
	








	//to pull from db with angularjs
	public function fetch_admin_bank_details()
	{
		header("content-type:application/json");
	echo (SiteSettings::where('criteria', 'admin_bank_details')->first()->settings );
	}


	public function update_admin_bank_details()
	{			
			print_r($_POST);


			SiteSettings::where('criteria', 'admin_bank_details')->first()
			->update(['settings'=> $_POST['content'] ]);
	

		Session::putFlash('success','Bank Details Updated Successfully!');
	}
	




	//to pull from db with angularjs
	public function fetch_compensation_breakdown()
	{
		header("content-type:application/json");
	echo (SiteSettings::where('criteria', 'compensation_breakdown')->first()->settings );
	}


	public function update_compensation_breakdown()
	{			
			print_r($_POST);


			SiteSettings::where('criteria', 'compensation_breakdown')->first()
			->update(['settings'=> $_POST['content'] ]);
	

		Session::putFlash('success','Compensation Break down Updated Successfully!');
	}
	


	//to pull from db with angularjs
	public function fetch_payout_structure()
	{
		header("content-type:application/json");
	echo (SiteSettings::where('criteria', 'payout_structure')->first()->settings );
	}


	public function update_payout_structure()
	{			
			print_r($_POST);

			SiteSettings::where('criteria', 'payout_structure')->first()
			->update(['settings'=> $_POST['content'] ]);
			Session::putFlash('success','Payout Structure Student Updated Successfully!');
	}
	




	//to pull from db with angularjs
	public function fetch_major_rank_qualification()
	{
		header("content-type:application/json");
		echo (SiteSettings::where('criteria', 'major_rank_qualification')->first()->settings );
	}


	public function update_major_rank_qualification()
	{
			
			// print_r($_POST);
			$settings  = json_decode($_POST['content'], true);  

			//remove all js 'hashKeys'
			foreach ($settings as $main_key => $main_class) {
					unset($settings[$main_key]['$$hashKey']);
				foreach ($main_class['sub_ranks'] as $key => $value) {
					unset($settings[$main_key]['sub_ranks'][$key]['$$hashKey']);
				}
			}

		
			// print_r(json_encode($settings));

			SiteSettings::where('criteria', 'major_rank_qualification')->first()
			->update(['settings'=> json_encode($settings)]);
			Session::putFlash('success','Rank Qualifications Updated Successfully!');
	}




}























?>