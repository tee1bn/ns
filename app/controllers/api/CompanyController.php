<?php

/**
 * 
*/
class CompanyController extends controller
{




	public function __construct(){

	}




	public function update_company_logo()
	{

		if ($_FILES['profile_pix']['error']!=4) {
			echo getcwd();
			$profile_pictures =	$this->update_company_logo_img($_FILES);
			Session::putFlash('success','Logo Updated Successfully.');
		}

		Redirect::back();
	}


	public function update_company_logo_img($file)
	{

		$directory = 'uploads/companies/logo';
		$handle = new Upload($file['profile_pix']);

		// $company = Company::find($_POST['company_id']);

		$auth = $this->auth();
		if ($auth->company == null) {

			$company =	Company::create([
					'user_id'=> $auth->id
				]);
		}else{

			$company = $auth->company;
		}




	                //if it is image, generate thumbnail
	                if (explode('/', $handle->file_src_mime)[0] == 'image') {
						$handle->Process($directory);
				 		$original_file  = $directory.'/'.$handle->file_dst_name;
	                }

				if ($company->logo != Config::default_profile_pix()) {
				(new Upload($company->logo))->clean();
				}			

					$company->update([
								'logo' => $original_file,
								]);
	}




	public function update_company()
	{

		echo "<pre>";
		print_r($_POST);

		$auth = $this->auth();
		if ($auth->company == null) {

			$company =	Company::create([
					'user_id'=> $auth->id
				]);
		}else{

			$company = $auth->company;
		}


		



				$this->validator()->check(Input::all() , array(

							'name' =>[
									'required'=> true,
									'min'=> 2,
										],

							'address' =>[
									'min'=> 3,
										],
					));


		 	if(!$this->validator()->passed()){
		 		Session::putFlash('danger', "Please try again ");
		 		return;
		 	}	

		 	if ($_POST['id'] == '') {


			 	Company::updateOrCreate(['id' => $_POST['id']],
			 							[
										'name' => $_POST['name'],
										'address' => $_POST['address'],
										'office_email' => $_POST['office_email'],
										'office_phone' => $_POST['office_phone'],
										'pefcom_id' => $_POST['pefcom_id'],
										'created_by' => $this->auth()->id,
										'rc_number' => $_POST['rc_number']
									]);
		 	}else{

			 	Company::updateOrCreate(['id' => $_POST['id']],
			 							[
										'name' => $_POST['name'],
										'address' => $_POST['address'],
										'office_email' => $_POST['office_email'],
										'office_phone' => $_POST['office_phone'],
										'pefcom_id' => $_POST['pefcom_id'],
										'rc_number' => $_POST['rc_number']
									]);




		 	}

		 	Session::putFlash('success', "Changes saved successfully.");
		 	Redirect::back();
		}




	public function index()
	{

		echo "index function";

	}



}























?>