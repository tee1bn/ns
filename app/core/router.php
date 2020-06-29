<?php 

$router =[
	''=>'home',
	'home'=>'home',
	// 'w'=>'home',
	'user'=>'UserController',			//this is used to build all urls of the user dashboard
	'withrawals'=>'WithdrawalsController',		

	'document' 			=> 'DocumentController',
	'support' 			=> 'SupportController',

	'user-profile'		=>'UserProfileController',
	'register' 			=> 'RegisterController',
	'login' 			=> 'LoginController',
	'verify' 			=> 'VerificationController',
	'shop' 				=> 'shopController',
	'error' 			=> 'ErrorController',
	'deposits'=>'DepositController',		
	'media' => 'crud/MediaController',

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
	'routine' => 'RoutineController',	//this handles routine checks and commssions

	'settings' => 'SettingsController',
	'testing' => 'testingController',
	'subscription_reminder' => 'SubscriptionReminder',


	'ticket_crud' => 'crud/TicketCrudController',
	'cms_crud' => 'crud/CmsCrud',
	'user_doc_crud' => 'crud/UserDocCrudController',





	'paypal' => 'payments/PayPalController', 


	#admin
	'admin-dashboard' => 'AdminDashboardController', 
	'admin' => 'AdminController', 
	'admin-profile' => 'AdminProfileController', 
	'admin-products' => 'AdminProductsController', 

	'isp' => 'IspUpgradeController', 
];

