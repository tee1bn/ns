<?php

namespace Apis;

use Illuminate\Database\Capsule\Manager as DB;
use MIS , SiteSettings;
/**



*/
class CoinWayApi 
{

	private $per_page = 100;



	public function __construct()
	{

		$this->settings = SiteSettings::site_settings();


		$this->url = "https://api.coinwaypay.com/api/supervisor/turnover";
		$this->api_key = $this->settings['coinway_sales_api_key'];

		$this->header = [
			$this->api_key
		];

	}



	public function setPeriod($start_date , $end_date)
	{
		$this->period =  [
			'start_date' => $start_date,
			'end_date' => $end_date,
		];

		return $this;

	}

	public function connect($skip=0)
	{



		// connect with API
		$query_string = http_build_query([
			'from' 	=> $this->period['start_date'],
			'to' 	=> $this->period['end_date'],
			'top' 	=> $this->per_page,
			'skip' => $skip
		]);

		$url = "{$this->url}?$query_string";

		$response = json_decode( MIS::make_get($url, $this->header) , true);


		print_r($response);

			$response = collect(json_decode( MIS::make_get($url, $this->header) , true));
	}

	

	public function index()
	{
		# code...
	}
}
















?>