<?php


namespace v2\Shop\Payments\Paypal;
use v2\Shop\Payments\Paypal\PayPal as cPaypal; //custom Paypal


use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;

use v2\Shop\Contracts\OrderInterface;
use Exception, SiteSettings, Config, MIS, Redirect;
/**
 * 
 */
class PaypalAgreement  extends cPaypal{

	private $plan ;
	private $plan_id ;
	private $agreement ;

	public function __construct()
	{
		parent::__construct();
	}

	public function setPlanId($plan_id)
	{
		$this->plan_id = $plan_id;
		return $this;
	}

	public function create()
	{
			
			$agreement = new Agreement();

			$agreement->setName('Base Agreement')
			    ->setDescription('Basic Agreement')
			    ->setStartDate('2019-06-17T9:45:04Z');


			    $plan = new Plan();
			    $plan->setId($this->plan_id);
			    $agreement->setPlan($plan);



			    $payer = new Payer();
			    $payer->setPaymentMethod('paypal');
			    $agreement->setPayer($payer);



			    $shippingAddress = new ShippingAddress();
			    $shippingAddress->setLine1('111 First Street')
			        ->setCity('Saratoga')
			        ->setState('CA')
			        ->setPostalCode('95070')
			        ->setCountryCode('US');
			    $agreement->setShippingAddress($shippingAddress);


			    $request = clone $agreement;


			    $agreement = $agreement->create($this->apiContext);

			    $approvalUrl = $agreement->getApprovalLink();


			    print_r($approvalUrl);



			return;
			$this->startAgreement();
			$this->agreement->setPlan($this->setPlan());
			$this->agreement->setPayer($this->setPayer());

		    $this->agreement->setShippingAddress($this->setShippingAddress());

			$request = clone $this->agreement;

			try {
				
				$agreement = $this->agreement->create($this->apiContext);
			    $approvalUrl = $agreement->getApprovalLink();

			} catch (PayPal\Exception\PayPalConnectionException $e) {
				
				print_r($e->getMessage());
			}


			return $agreement;
	}



	public function startAgreement()
	{
		$today = date("Y-m-d H:i:s");

		$this->agreement = new Agreement();

		$this->agreement->setName('Base Agreement')
		    ->setDescription('Basic Agreement')
		    ->setStartDate('2019-06-17T9:45:04Z');

		 return   $this;
	}


	protected function setPlan()
	{
		$plan = new Plan();
		$plan->setId($this->plan_id);

		return $plan;
	}


	protected function setPayer()
	{
		$payer = new Payer();
		$payer->setPaymentMethod('paypal');

		return $payer;
	}



	protected function setShippingAddress()
	{

		$shippingAddress = new ShippingAddress();
		$shippingAddress->setLine1('111 First Street')
		    ->setCity('Saratoga')
		    ->setState('CA')
		    ->setPostalCode('95070')
		    ->setCountryCode('US');

		    return $shippingAddress;
	}

}

