<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as Eloquent;



class Company extends Eloquent 
{
	
	protected $fillable = [
				'organisation_id',
				'user_id',
				'name',
				'address',
				'office_email',
				'office_phone',
				'pefcom_id',	//pension fund employer code
				'rc_number',   //cac registration number
				'bn_number',	//cac business registration number
				'company_description',
				'approval_status',
				'documents',
				'logo'
	];
	
	protected $connection = 'default';
	protected $table = 'companies';


	public  $compulsory = [ 
						'name',
						'office_email',
						'documents'
							];



	public function delete_document($key)
	{

		$doc = $this->documents;
		$tobe_deleted = ($doc[$key]);
		unset($doc[$key]);

		DB::beginTransaction();

		try {
			
			$this->update(['documents' => json_encode($doc)]);

			DB::commit();
			Session::putFlash("success","{$tobe_deleted['label']} Deleted Successfully");
			return true;
		} catch (Exception $e) {
			DB::rollback();
			Session::putFlash("danger","Could not delete ");
			return false;
		}

	}



	public  function upload_documents($files)
	{
		$directory = 'uploads/companies/documents';

		echo "string";

		$documents = $this->documents;
		$i = 0;


		
		DB::beginTransaction();

		try {
			


			foreach ($files as $label => $file) {

				$handle = new Upload ($file);


						$file_type = explode('/', $handle->file_src_mime)[0];
		                if (($file_type == 'image' ) ||($file_type == 'video' ) ) {

		                	$handle->Process($directory);
		                	$file_path = $directory.'/'.$handle->file_dst_name;

								$new_file[$i]['files'] = $file_path;
								$new_file[$i]['label'] = $label;

								array_unshift($documents, $new_file[$i]);
		                }
		                $i++;
			}



				$this->update([
						'documents'=> json_encode($documents)
					]);

			DB::commit();
			Session::putFlash("success","Documents Uploaded Successfully");
		} catch (Exception $e) {
			DB::rollback();
			Session::putFlash("danger","Documents Uploaded Failed.");
			
		}

		return ($documents);


	}


	public function user()
	{

		return $this->belongsTo('User', 'user_id');
	}


	public function is_ready_for_verification()
	{

		    foreach (self::$compulsory as $file) {
    			if ($this->$file == null) {
    				return false;
    			}
    		}

    	return true;
	}

	public function getApprovalAttribute()
    {

    		switch ($this->approval_status ) {
    			case 'approved':
	              $status = "<span type='span' class='badge badge-xs badge-success'>Approved</span>";
    				break;
    			
    			case 'declined':
	              $status = "<span type='span' class='badge badge-xs badge-danger'>Declined</span>";
    				break;

    			default:


	              $status = "<span type='span' class='badge badge-xs badge-info'>Verifying</span>";
    				break;
    		}

               return $status;
    }





	public function getgetLogoAttribute()
	{

		 $value = $this->logo;
		if (! file_exists($value) &&  (!is_dir($value))) {
        	return (Config::logo());
    	}

    	$pic = Config::domain()."/$value";

	   	return $pic;
	}






	public function getdocumentsAttribute($value)
	{	
		if ($value == null) {
			
			return [];			
		}
		return json_decode($value , true);
	}




}


















?>