<?php

use Illuminate\Database\Capsule\Manager as DB;

/**
 * this class is the default controller of our application,
 *
 */
class UserProfileController extends controller
{


    public function __construct()
    {

    }


    /**
     *
     */
    public function set_contact_availability()
    {

        $auth = $this->auth();
        $existing_settings = $auth->SettingsArray;
        $existing_settings['contact_availability'] = $_POST['contact_availability'] ?? 0 ;
        $auth->save_settings($existing_settings);
        switch ($existing_settings['contact_availability']) {
            case 1:
                Session::putFlash('success', "Your contact will be available to your entire upline");
                break;

            default:
                Session::putFlash('success', "Your contact will not be available to your entire upline");
                break;
        }

        Redirect::back();


    }
    public function update_payment_info()
    {
        echo "<pre>";

        print_r(Input::all());
        print_r($_FILES);
        if (Input::exists('update_payment_info')) {


            $this->validator()->check(Input::all(), array(

                'account_name' => [
                    'required' => true,
                    'min' => 3,
                    'max' => 32,
                ],
                'bank_name' => [
                    'required' => true,
                    'min' => 3,
                    'max' => 32,
                ],
                'account_number' => [
                    'required' => true,
                    'numeric' => true,
                    'min' => 3,
                    'max' => 32,
                ],
            ));


            if ($this->validator->passed()) {

                $this->auth()->payment_information->update([
                    'bank_account_name' => Input::get('account_name'),
                    'bank_account_number' => Input::get('account_number'),
                    'bank_name' => Input::get('bank_name'),
                ]);


                if ($_FILES['upload']['error'] !== 4) {
                    $original_file = $this->upload_userid_proof($_FILES);
                    $this->auth()->payment_information->update(['id_proof' => $original_file]);

                }

                Session::putFlash('info', 'Payment Information updated successfully!');
            } else {


            }


        }


        Redirect::to('user/payment-information');

    }


    public function upload_userid_proof($files)
    {

        print_r($files);


        $directory = 'uploads/images/users/id_proofs';
        $handle = new Upload($files['upload']);

        //if it is image, generate thumbnail
        if (explode('/', $handle->file_src_mime)[0] == 'image') {
            $handle->Process($directory);
            $original_file = $directory . '/' . $handle->file_dst_name;

            (new Upload($this->auth()->payment_information->id_proof))->clean();

            return $original_file;

        }

    }


    public function change_password()
    {

        if (/*Input::exists('change_password')*/
        true) {

            $this->validator()->check(Input::all(), array(

                'current_password' => [
                    'required' => true,
                    'min' => 3,
                    'max' => 32,
                ],

                'new_password' => [

                    'required' => true,
                    'min' => 6,
                    'max' => 32,
                ],

                'confirm_password' => [
                    'required' => true,
                    'matches' => 'new_password',
                ]

            ));


            if (!password_verify(Input::get('current_password'), $this->auth()->password)) {
                $this->validator()->addError('current_password', "current password do not match");

            }

            if ($this->validator()->passed()) {

                User::find($this->auth()->id)->update(['password' => Input::get('new_password')]);

                $user = User::where('id', $this->auth()->id)->first();

                Session::putFlash('success', "Password changed successfully!");

            } else {

                Session::putFlash('danger', Input::inputErrors());
                // Session::putFlash('danger', "Please try again ");

            }


        }
        Redirect::back();

    }


    public function update_user()
    {
        echo "<pre>";

        print_r($_POST);

        //validation
        $validator = new Validator;
        //personal
        $validator->check($_POST['personal'], array(


            'username' => [
                 'required'=> true,
                'min' => 1,
                'one_word' => true,
                'no_special_character' => true,
                'replaceable' => 'User|' . $this->auth()->id,
            ],


            'title' => [
                'required' => true,
            ],

            'firstname' => [
                'required' => true,
                'max' => '32',
                'min' => '2',
            ],

            'lastname' => [
                'required' => true,
                'max' => '32',
                'min' => '2',
            ],

            'country' => [
                'required' => true,
            ]

        ));

        //personal address
        $validator->check($_POST['personal']['address'], array(

            'place' => [
                'required' => true,
            ],

            'post_code' => [
                'required' => true,
            ],


            'address' => [
                'required' => true,
            ],

            'house_number' => [
                'required' => true,
            ]
        ));


        //business
        $validator->check($_POST['company'], array(
            'name' => [
                'required' => true,
            ],
            'legal_form' => [
                'required' => true,
            ],
            'vat_number' => [
                'required' => true,
            ],
            'country' => [
                'required' => true,
            ],
            'office_email' => [
                'required' => true,
                'email' => true,
            ],
            'office_phone' => [
                'required' => true,
            ],
            'iban_number' => [
                'required' => true,
            ],

        ));

        //business address
        $validator->check($_POST['company']['address'], array(

            'place' => [
                'required' => true,
            ],

            'post_code' => [
                'required' => true,
            ],


            'address' => [
                'required' => true,
            ],

            'house_number' => [
                'required' => true,
            ]
        ));


        if (! $validator->passed()){
            Session::putFlash('danger', Input::inputErrors());
            Redirect::back();
        }

        DB::beginTransaction();

        try{

            //personal update
            $auth = $this->auth();
            $personal = $_POST['personal'];
            $auth->update([
                "username" => $personal['username'],
                "salutation" => $personal['salutation'],
                "title" => $personal['title'],
                "firstname" => $personal['firstname'],
                "lastname" => $personal['lastname'],
                "country" => $personal['country'],
                "address" => json_encode($personal['address']),
            ]);

            //company update
            $company = $auth->company;
            $business  = $_POST['company'];
            $company->update([
                "name" => $business['name'],
                "legal_form" => $business['legal_form'],
                "vat_number" => $business['vat_number'],
                "country" => $business['country'],
                "address" => json_encode($business['address']),
                "office_email" => $business['office_email'],
                "office_phone" => $business['office_phone'],
                "iban_number" => $business['iban_number'],
            ]);


            DB::commit();
            Session::putFlash("success","Changes saved successfully.");
        }catch (Exception $e){
            DB::rollback();
            Session::putFlash("danger","Something went wrong.");

        }

        Redirect::back();

        print_r($validator->errors());
    }


    public function update_profile()
    {

        echo "<pre>";
        if (/*Input::exists('update_user_profile')*/
        true) {

            // print_r($_FILES);


            $this->validator()->check(Input::all(), array(


                'title' => [
                    'required' => true,
                ],


                'firstname' => [
                    'required' => true,
                    'max' => '32',
                    'min' => '2',
                ],


                'username' => [
                    // 'required'=> true,
                    'min' => 1,
                    'one_word' => true,
                    'no_special_character' => true,
                    'replaceable' => 'User|' . $this->auth()->id,
                ],


                'email' => [
                    'required' => true,
                    'email' => true,
                    'replaceable' => 'User|' . $this->auth()->id,
                ],

                'lastname' => [
                    'required' => true,
                    'max' => '32',
                    'min' => '2',
                ],

                'address' => [
                    'required' => true,
                    'max' => '255',
                    'min' => '2',
                ],

                'country' => [
                    'required' => true,
                ],

                'phone' => [
                    'required' => true,
                    'max' => '32',
                    'min' => '2',
                ],

                'bank_name' => [
                    // 'required'=> true,
                    'max' => '32',
                    'min' => '2',
                ],

                'bank_account_name' => [
                    // 'required'=> true,
                    'max' => '32',
                    'min' => '2',
                ],

                'bank_account_number' => [
                    // 'required'=> true,
                    'numeric' => true,
                    'max' => '32',
                    'min' => '2',
                ],


            ));


            if ($this->validator->passed()) {
                if ($this->auth()->email != $_POST['email']) {

                    $this->auth()->update(['email_verification' => md5(uniqid())]);
                }


                if ($this->auth()->phone != $_POST['phone']) {

                    $this->auth()->update(['phone_verification' => User::generate_phone_code_for($this->auth()->id)]);
                }


                $this->auth()->update(Input::all());


                Session::putFlash('success', 'Profile updated successfully!');

            } else {

// print_r($this->validator->errors());
                Session::putFlash('info', $this->inputErrors());
            }


        }


        Redirect::back();

    }

    public function update_profile_picture()
    {

        if ($_FILES['profile_pix']['error'] != 4) {
            $profile_pictures = $this->update_user_profile($_FILES);
            Session::putFlash('success', 'Profile Picture Updated Successfully.');
        }

        Redirect::back();
    }


    public function update_user_profile($file)
    {
        $directory = 'uploads/images/users/profile_pictures';
        $handle = new Upload($file['profile_pix']);

        //if it is image, generate thumbnail
        if (explode('/', $handle->file_src_mime)[0] == 'image') {

            // $handle->file_new_name_body = "{$this->auth()->username}";

            $handle->Process($directory);
            $original_file = $directory . '/' . $handle->file_dst_name;

            // we now process the image a second time, with some other settings
            $handle->image_resize = true;
            $handle->image_ratio_y = true;
            $handle->image_x = 50;

            // $handle->file_new_name_body = "{$this->auth()->username}";
            $handle->Process($directory);

            $resize_file = $directory . '/' . $handle->file_dst_name;


        }


        $profile_pictures = ['original_file' => $original_file, 'resize_file' => $resize_file];


        if ($this->auth()->profile_pix != Config::default_profile_pix()) {
            (new Upload($this->auth()->profile_pix))->clean();
        }

        if ($this->auth()->resized_profile_pix != Config::default_profile_pix()) {
            (new Upload($this->auth()->resized_profile_pix))->clean();
        }

        $this->auth()->update([
            'profile_pix' => $profile_pictures['original_file'],
            'resized_profile_pix' => $profile_pictures['resize_file']
        ]);


        return $profile_pictures;
    }

}


?>