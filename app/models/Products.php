<?php

use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Eloquent\Model as Eloquent;

use  v2\Models\Market;


class Products extends Eloquent 
{
	
		protected $fillable = [
						'name',
						'scheme',
						'price',
						'category_id',
						'ribbon',
						'old_price',
						'commission_price',
						'description',
						'front_image',
						'downloadable_files',
						'back_image',
						'on_sale',
							];
	
	protected $table = 'products';


    protected $hidden = ['downloadable_files'];

    public static $category_in_market = 'product';






    


    public function getimageJsonAttribute()
    {   
        $value = $this->image;


        if ((!is_dir($value))  && (file_exists($value))) {

            return ($value);
        }

        return 'uploads/images/courses/course_image.jpeg';
    }



    public static function star_rating($rate,  $scale)
    {
        $stars = '';
        for ($i=1; $i <= $scale ; $i++) { 
                if ($i <= $rate) {
                    $stars .= "<i class='fa fa-star'></i>";
                }else{
                    $stars .= "<i class='fa fa-star-o'></i>";
                }
        }

        $point = number_format(($rate), 1);
        $stars .= " (<b>$point</b>)";
        $star_rating = compact('rate', 'scale', 'stars', 'point');

        return $star_rating;
    }



    public function quickview()
    {

        $currency = Config::currency();
        $price = MIS::money_format($this->price);
        $by = ($this->instructor == null)? '' : "By {$this->instructor->fullname} ";


        $last_updated = date("M j, Y h:iA" , strtotime($this->updated_at));
        $quickview = "
            <small>Last updated -{$last_updated}</small>
            <h5><b>{$this->title}</b></h5>
            <p> $this->primarily_taught | $this->category | $this->level</p>
            <p>$by <span style='margin-left: 30px;    font-weight: bold;    font-size: 25px;'> $currency$price</span>
            </p> 
            <hr>

            <p>$this->description</p>
            <ul>

            </ul>
         
          ";

          return $quickview;
    }

    public function scopeFree($query)
    {
        return $query->where('price', 0);
    }

    
    
    public function is_free()
    {
        return $this->price == 0;
    }



    public function getViewLinkAttribute()
    {
        $domain = Config::domain();

        $url_friendly = MIS::encode_for_url($this->title);
        $category_in_market = self::$category_in_market;
        $singlelink = "$domain/shop/full-view/$this->id/$category_in_market/$url_friendly";

        return $singlelink;  
    }


    public function market_details()
    {

        $domain = Config::domain();
        $thumbnail = "$this->mainimage";
        $market_details = [
            'id' => $this->id,
            'model' => self::class,
            'name' => $this->name,
            'short_name' => substr($this->name, 0, 34),
            'description' => $this->description,
            'short_description' => substr($this->description, 0, 50).'...',
            'quick_description' => substr($this->description, 0, 250).'...',
            'commission_price' => $this->commission_price,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'by' => ($this->instructor == null)? '' : "By {$this->instructor->fullname}",
            'star_rating' => self::star_rating(4, 5),
            'quickview' =>  $this->quickview(),
            'single_link' =>  $this->ViewLink,
            'thumbnail' =>  $thumbnail,
            'unique_name' =>  'product',  // this name is used to identify this item in cart and at delivery
        ];

        return $market_details;
    }   






	public function download()
	{


		$type = MIS::custom_mime_content_type( $this->downloadable_files);

		$filename = end(explode('/', $this->downloadable_files));

		if (! file_exists($this->downloadable_files)) {
			Session::putFlash('danger', "could not fetch file");
			return;
		}

			header("Content-type: $type");
			header('Content-Disposition: attachment; filename="'.$filename.'"');

			readfile($this->downloadable_files);
			exit();
	}



	public function scheme_attached()
	{
		return $this->belongsTo('SubscriptionPlan', 'scheme');
	}

	public static function accessible($subscription_id)
	{	
		$sub 	 = SubscriptionPlan::find($subscription_id);
		$sub_ids = SubscriptionPlan::where('hierarchy', '=', (int)$sub->hierarchy)
									->get()
									->pluck('id')
									->toArray();
		$sub_ids[] = 'free';

		$accessibles =  self::whereIn('scheme', $sub_ids);

		return $accessibles;
	}
	



	public static function validate_cart($cart_items)
	{
		$errors = [];
		$totals = [];
		foreach ($cart_items as $key => $item) {
			 $real_product =  self::find($item['id']);
				$totals[] = $real_product->price * $item['qty'];
				if (
				 	($real_product->price != $item['price'])
				 	) {
				 	$errors['price'] = "incorrect";

				 	return false;
				}

				return true;
		}



	}

	public function getpercentdiscountAttribute()
	{
		if (($this->old_price==null) ||($this->old_price <= $this->price) ) {
			return 0;
				}		

		return  (int) (($this->old_price - $this->price) * (100 / $this->old_price));
	}


	public function is_ready_for_review()
	{
		return true;
	}

	public function update_product($inputs, $files, $downloadable_files)
	{


			if (Input::exists('')  || true) {
				$validator = new Validator;
			$validator->check(Input::all() , array(

										'name' =>[

											'required'=> true,
											'min'=> 2,
										],
										'price' =>[

											'required'=> true,
											'min'=> 1,
											'max'=> 20,	
											'numeric'=> true,
										],

										'description' => [
											'required'=> true,
											'min'=> 4,
										]
					));
			 if($validator->passed()){

			 	DB::beginTransaction();
			 		try{
					 	$this->update([
									'name' 		=> $inputs['name'],
									'price' 	=> $inputs['price'],
									'commission_price' 	=> $inputs['commission_price'],
									'scheme' 	=> $inputs['scheme'],
									'category' 	=> $inputs['category_id'],
									'description' => $inputs['description'],
									'ribbon' => $inputs['ribbon'],
									'old_price' => $inputs['old_price'],
					 				]);
			 			$this->update_product_images($files, $inputs['images_to_be_deleted']);
			 			$this->upload_downloadable_files($downloadable_files);

			 			DB::commit();
						Session::putFlash('success','Changes Saved Successfully.');

			 			return true;
			 			return true;
			 		}catch(Exception $e){
			 			DB::rollback();
						Session::putFlash('danger', "Seems {$inputs['name']} already exist.");
			 			print_r($e->getMessage());
			 			return false;
			 		}

			 }else{

				Session::putFlash('danger',Input::inputErrors());

			 }
		}
	

	}



	public function upload_downloadable_files($file)
	{
		$directory = 'uploads/images/downloadable_files';


						$handle = new Upload ($file);

	                	$handle->Process($directory);
	                	$file_path = $directory.'/'.$handle->file_dst_name;

	       $this->update(['downloadable_files' => $file_path]);
		return ($file_path);


	}



	public static function upload_post_images($files)
	{
		$directory = 'uploads/images/products';


		$refined_file = MIS::refine_multiple_files($files);


		$i = 0;
		foreach ($refined_file as  $file) {

			$handle = new Upload ($file);


					$file_type = explode('/', $handle->file_src_mime)[0];
	                if (($file_type == 'image' ) ||($file_type == 'video' ) ) {



						$min_height = 350;
						$min_width  = 263;

					

	                	$handle->Process($directory);
	                	$file_path = $directory.'/'.$handle->file_dst_name;

	                	if ($file_type == 'image') {

	                         // we now process the image a second time, with some other settings
				            $handle->image_resize            = true;
				            // $handle->image_ratio_y           = true;
				            $handle->image_x                 = $min_width;
				            $handle->image_y                 = $min_height;

				            $handle->Process($directory);

				            $resized_path    = $directory.'/'.$handle->file_dst_name;

							$images[$i]['main_image'] = $file_path;
							$images[$i]['thumbnail'] = $resized_path;
						}

	                }
	                $i++;
		}



			$property_media = [
			'images' => $images,
					];




		return ($property_media);


	}






	public function update_product_images($files, $images_to_be_deleted=[])
	{

		$property_media =	$this->upload_post_images($files);

		

	    $new_images = $property_media['images'];


        $previous_images =  $this->images['images'];


        //delete necessary ones
			foreach ($images_to_be_deleted as $value) {
				$images_in_previous = $previous_images[$value];
				foreach ($images_in_previous as $image_path) {
				$handle =  new Upload($image_path);
				$handle->clean();
				}

				unset($previous_images[$value]);
			}
		($updated_previous_images = array_values($previous_images)); //after removing some
			
			if (array_values($previous_images) == null) {
				$updated_previous_images =  [];
			}

        foreach ($new_images as  $image) {
        	array_unshift($updated_previous_images, $image);
	        }





			$updated_files = [
								'images' => $updated_previous_images
								];

		$this->update(['front_image'=> json_encode($updated_files)]);
	}




	public function getdeletelinkAttribute($value)
	{
		return  Config::domain()."/admin-products/deleteProduct/{$this->id}";
	}


	public function related_products()
	{
		return	self::where('id', '!=' ,$this->id)
					->whereRaW("(category_id = '$this->category_id' OR id != $this->id )")
					->latest()->take(20)->get()->shuffle()->take(4);
	}


	public function getimagesAttribute()
	{
		return json_decode($this->front_image, true);
	}



	public static  function default_ebook_pix()
	{
		return 'https://wrappixel.com/demos/admin-templates/monster-admin/assets/images/big/img1.jpg';
	}




	//market approval status
	public function getApprovalStatusAttribute()
	{

	      $last_submission =  Market::where('category', $this::$category_in_market)
	                        ->where('item_id', $this->id)
	                        ->latest()
	                        ->first();

	        if ($last_submission == null) {
	            return "<span class='badge badge-sm badge-dark'>Drafting</span>";
	        }

	        switch ($last_submission->approval_status) {
	        case 2:
	            $status = "<span class='badge badge-sm badge-success'>Approved</span>";
	            break;
	        
	        case 1:
	            $status = "<span class='badge badge-sm badge-warning'>In review</span>";
	            break;
	    
	        case 0:
	            $status = "<span class='badge badge-sm badge-danger'>Declined</span>";
	            break;

	        case null:
	        $status = "<span class='badge badge-sm badge-info'>unknown</span>";
	        break;
	    
	        
	        default:
	            # code...
	            break;
	    }

	    return $status;

	}


	public static function approved()
	{
	    return self::where('status', 'Approved');
	}

	public static function in_review()
	{
	    return self::where('status', 'In review');
	}


	public  static function draft()
	{
	    return self::where('status', 'Draft');
	}


	public  static function denied()
	{
	    return self::where('status', 'Denied');
	}



	public function getmainimageAttribute()
	{
		$value =  $this->images['images'][0]['main_image'];

		if (! file_exists($value) &&  (!is_dir($value))) {
	        return (self::default_ebook_pix());
    	}

    	$pic_path = Config::domain()."/".$value;
	   	return $pic_path;
	}



	public function getsecondaryimageAttribute()
	{
		if (($this->images['images'][1] !=null ) && ( file_exists($this->images['images'][1]['main_image']))) {
			return $this->images['images'][1];
		}
			return $this->mainimage;
	}





	public function getregularpriceAttribute()
	{	
		if ($this->old_price != '') {
			return  Config::currency().' '.number_format($this->old_price,2);		
		}
	}




	public static function upload_product_images($files)
	{
		$directory = 'uploads/images/products';

		foreach ($files as $attribute => $attributes) {
			foreach ($attributes as $key => $value) {
				$refined_file[$key][$attribute] = $value;
			}

		}

		$i = 0;
		foreach ($refined_file as  $file) {

			$handle = new Upload ($file);


					$file_type = explode('/', $handle->file_src_mime)[0];
	                if (($file_type == 'image' ) ||($file_type == 'video' ) ) {



						$min_height = 335;
						$min_width  = 270;

						// echo $handle->image_src_x;

						if (($handle->image_src_x < $min_width) || ($handle->image_src_y < $min_height) ) {

							Session::putFlash('info', "Item image $i) must be or atleast {$min_width}px min 
								width x {$min_height}px min height for best fit!");
							continue;
						}


	                	$handle->Process($directory);
	                	$file_path = $directory.'/'.$handle->file_dst_name;

	                	if ($file_type == 'image') {

	                         // we now process the image a second time, with some other settings
				            $handle->image_resize            = true;
				            // $handle->image_ratio_y           = true;
				            $handle->image_x                 = 350;
				            $handle->image_y                 = 263;

				            $handle->Process($directory);

				            $resized_path    = $directory.'/'.$handle->file_dst_name;

							$images[$i]['main_image'] = $file_path;
							$images[$i]['thumbnail'] = $resized_path;
						}

	                }
	                $i++;
		}



			$property_media = [
			'images' => $images,
					];




		return ($property_media);


	}


	public function quickdescription()
	{
		return substr($this->description, 0, random_int(240, 450) ).'...';
	}



	public function url_link()
	{
		return Config::domain()."/shop/product_detail/{$this->id}/{$this->url_title()}";
	}


	public function url_title()
	{
			return str_replace(' ', '-', trim($this->name));
	}


	public  function is_on_sale()
	{
		return (bool)($this->on_sale == 1);
	}

	public static function on_sale()
	{
		return self::where('on_sale' , 1);
	}

	public function category()
	{
		return $this->belongsTo('ProductsCategory' , 'category_id');
	}

}


















?>