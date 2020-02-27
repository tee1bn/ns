<?php

/**
* This is where all miscellaneous operational functions is done
*/
class MIS 
{
	
	

	function show_flash()
	{
	            
	    if (! isset($_SESSION['flash'])) {
	        return;
	    }


	    $message = '';
	    foreach($_SESSION['flash'] as $flash){

	        $message .= $flash['message'];
	    }

	    $type = end($_SESSION['flash'])['title'];


	    $notification = "
	                    <div id='gitstar-notification'  class='alert alert-$type alert-dismissible' >
	                    <a href='#' class='close' data-dismiss='alert' aria-label='close' title='close'>×</a>
	                        <span>$message</span>    
	                    </div>";

	    unset($_SESSION['flash']);
	    return $notification;
	}

	
	public static function money_format($string)
	{
		return number_format("$string",2);		
	}

function generate_form($data, $action, $button, $function='', $require_confirmation=false)
{
    $inputs = '';
    foreach ($data as $key => $value) {
        $inputs.= "<input type='hidden' name='$key' 
        value='$value'> ";
    }

    if ($function == '' ) {
        $function_attribute = '';
    }else{
        $function_attribute = "data-function='$function'";
    }

    if ($require_confirmation==true) {
    	$btn=  '<button type="button" onclick="$confirm_dialog = new DialogJS(submit_form, [this])"  class="btn btn-sm btn-secondary">'.$button.'</button>';

    }else{

    	$btn=  '<button type="submit"   class="btn btn-secondary">'.$button.'</button>';
    }

    $form = '';

    $form = <<<EOL

    <form style="display: inline;" id="q_form" $function_attribute class="ajax_form" method="post" action="$action">
    $inputs  
    $btn
    </form>

    <script>
      submit_form = function(btn){
        btn.parentNode.submit();
      }
      
    </script>

EOL;
                              
    return $form;

}


	
    public static function custom_mime_content_type($filename)
    {

    	if(function_exists('mime_content_type')&&$mode==0){ 
        $mimetype = mime_content_type($filename); 
        return $mimetype; 

		}elseif(function_exists('finfo_open')&&$mode==0){ 
		        $finfo = finfo_open(FILEINFO_MIME); 
		        $mimetype = finfo_file($finfo, $filename); 
		        finfo_close($finfo); 
		        return $mimetype; 
		}elseif(array_key_exists($ext, $mime_types)){ 
		        return $mime_types[$ext]; 
		}else { 
		        return 'application/octet-stream'; 
		} 


    }




    public static function use_google_recaptcha()
    {

    	    $settings = SiteSettings::site_settings();
    	    $key = $settings['google_re_captcha_site_key'];
    	    
    	    $recaptcha = <<<EOL
    	    <div class="g-recaptcha form-group" data-sitekey="$key">
    	    </div>
EOL;

    	    return $recaptcha;
    }

	public static function verify_google_captcha()
	{
		$domain =Config::domain();
		if (strpos($domain, '.') == false) {
		    return true;
		}


		

		 	$settings = SiteSettings::site_settings();		 	
			$post_data =  [
							'secret'=> $settings['google_re_captcha_secret_key'],
							'response'=> $_POST['g-recaptcha-response'],
						];
    			$response = self::make_post("https://www.google.com/recaptcha/api/siteverify", $post_data);


			$csrf =  (json_decode($response, true));
					
			if(($csrf['success'] != 1) || ($csrf['hostname'] != $_SERVER['HTTP_HOST'])){
			    Session::putFlash('warning', "Please solve the captcha");
			    Redirect::back();
			}

	}



    public static 	function random_string( $length = 6 ) {
		    $chars = "abcdefghijkmnpqrtwyz123456789";
		    $password = substr(str_shuffle( $chars ), 0, $length);
		    return $password;
	}



	public static function refine_multiple_files($files)
	{
		foreach ($files as $attribute => $attributes) {
			foreach ($attributes as $key => $value) {
				$refined_file[$key][$attribute] = $value;
			}
		}
		return $refined_file;
	}



	public static function date_range($date, $duration="month" , $strict=false)
	{
		$explode = explode("-", $date);
		$year = @$explode[0];
		$month = @$explode[1];
		$day =  @$explode[2];


		switch ($duration) {
			case 'month':
				$today = date("Y-m");
				$year_month = "$year-$month";
				if (($today == $year_month) && ($strict==false)) {
					$end_date = date("Y-m-d");
				}else{
					$end_date = date("$year-$month-t");
				}

				$range =  [
					'start_date' => date("$year-$month-01"),
					'end_date' => $end_date
				];

				break;

			case 'year':
				$today = date("Y");
				if (($today == $year) && ($strict==false)) {
					$end_date = date("Y-m-d");
				}else{
					$end_date = date("$year-12-t");
				}

				$range =  [
					'start_date' => date("$year-01-01"),
					'end_date' => $end_date
				];

				break;
			

			case 'week':
				 $today = date("l");
             

				 $weekday = date("l", strtotime($date));

				if (($today == $weekday) && ($strict==false)) {
					$end_date = date("Y-m-d",strtotime("$today this week"));
				}else{
					$end_date = date("Y-m-d",strtotime("$date sunday this week"));
				}

				$range =  [
					'start_date' => date("Y-m-d",strtotime("$date monday this week")),
					'end_date' => $end_date
				];

				break;
			
				


			default:
				# code...
				break;
		}

		return $range;
	}




	function ends_with($haystack, $needle) {
	    // search forward starting from end minus needle length characters
	    return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}

	function starts_with($haystack, $needle){
	    $length = strlen($needle);
	    return (substr($haystack, 0, $length) === $needle);
	}




	public static function make_post($url, $post_data,  $header=[])
	{

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, "$url");
		curl_setopt($ch, CURLOPT_POST, 1);
	


		if (count($header)>0) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}


		// In real life you should use something like:
		curl_setopt($ch, CURLOPT_POSTFIELDS, 
		         http_build_query($post_data));

		// Receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$server_output = curl_exec($ch);

		curl_close ($ch);

		return $server_output;


 
	}


	public static function make_get($url,  $header=[])
	{

		$ch = curl_init($url);

		if (count($header)>0) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		}

		// Receive server response ...
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


		 $result = curl_exec($ch);
		// $response = curl_getinfo($ch);

		curl_close ($ch);

		return $result;
	}





}