<?php 

$router =[
	''=>'home',
	'home'=>'home',
	// 'w'=>'home',
	'user'=>'UserController',			//this is used to build all urls of the user dashboard

	'document' 			=> 'DocumentController',
	'support' 			=> 'SupportController',

	'user-profile'		=>'UserProfileController',
	'register' 			=> 'RegisterController',
	'login' 			=> 'LoginController',
	'verify' 			=> 'VerificationController',
	'shop' 				=> 'shopController',
	'error' 			=> 'ErrorController',

	'test' => 'test/home',

	'company' => 'api/CompanyController',

	'cms_api' => 'CmsApiController',
	'guest' 	=> 'GuestController',
	'terms' 	=> 'TermsController',
	'genealogy' => 'GenealogyController',
	'report' 	=> 'ReportsController',
	'ref' 		=> 'ReferralController', //referral link handler
	'forgot-password' 	=> 'forgotPasswordController',

	'auto-match' => 'AutoMatchingController',	//this handles routine checks and commssions

	'settings' => 'SettingsController',
	'testing' => 'testingController',





	'paypal' => 'payments/PayPalController', 


	#admin
	'admin-dashboard' => 'AdminDashboardController', 
	'admin' => 'AdminController', 
	'admin-profile' => 'AdminProfileController', 
	'admin-products' => 'AdminProductsController', 
];

