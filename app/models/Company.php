<?php


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
				'logo'
	];
	
	protected $connection = 'default';
	protected $table = 'companies';




	public function user()
	{

		return $this->belongsTo('User', 'user_id');
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







}


















?>