<?php

namespace Apis;

use Illuminate\Database\Capsule\Manager as DB;
use MIS , SiteSettings;
/**



*/
class CoinWayApi 
{

	public $per_page = 100;
	public $response = [];
	public $total_no ;


	public function __construct()
	{

		$this->settings = SiteSettings::site_settings();


		$this->url = "https://api.coinwaypay.com/api/supervisor/turnover";
		$this->api_key = $this->settings['coinway_sales_api_key'];

		$this->header = [
			$this->api_key
		];

		// print_r($this->header);
		// echo "<pre>";
	}

	//RETURNS sales partners and their quantitative details
	public static function api($date = null)
	{
	    $coin_way = new self;

	    $today = $date ?? date("Y-m-d");
	    $date_range = MIS::date_range($today);


	    $response = $coin_way->setPeriod($date_range['start_date'], $date_range['end_date'])
	        ->connect()->get_response()->keyBy('supervisorNumber');


	   return $response;

	}


	public function setUrl($url)
	{
		$this->url = $url;

		return $this;
	}

	public function setPeriod($start_date , $end_date)
	{
		$this->period =  [
			'start_date' => $start_date,
			'end_date' => $end_date,
		];

		return $this;
	}

	




	//connect with the API using the sent param
	public function connect($param = null, $get_meta_data=false, $paginate=false)
	{

		// connect with API

		$param_array = $param ?? [
			'from' 	=> $this->period['start_date'],
			'to' 	=> $this->period['end_date'],
		];

		$query_string = http_build_query($param_array);

		$url = "{$this->url}?$query_string";

		$response = json_decode( MIS::make_get($url, $this->header) , true);



		$this->total_no  = $response['totalCount'];

		if ($get_meta_data == true) {

			$full_response['meta']['total'] = $this->total_no;
			$full_response['values'] = $response['value'];

			$this->response = $full_response;

		}else{

			$this->response = $response['value'];
		}


		if ($paginate) {

			return $this;
		}else{

			if ($get_meta_data == true) {
				$this->response = [
					'values' => []
				];
			}else{

				$this->repsonse= [];
			}

		}






		$pages = ceil($this->total_no  /$this->per_page);

		for ($i=1; $i <= $pages ; $i++) { 
			$skip = ($this->per_page * ($i-1));


			$query_string = http_build_query([
				'from' 	=> $this->period['start_date'],
				'to' 	=> $this->period['end_date'],
				'$top' 	=> $this->per_page,
				'$skip' => $skip
			]);


		$response = json_decode( MIS::make_get($url, $this->header) , true);


			if ($get_meta_data == true) {

				$response = array_merge($this->response['values'], $response['value']);

				$full_response['meta']['total'] = $this->total_no;
				$full_response['values'] = $response;

				$this->response = $full_response;

			}else{

				$this->response = $response;
			}

		}


		return $this;

	}


	public function get_response()
	{
		return collect($this->response);
	}
	

	public function index()
	{
		# code...
	}
}
















?>