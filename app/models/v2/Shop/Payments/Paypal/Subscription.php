<?php


namespace v2\Shop\Payments\Paypal;
use v2\Shop\Payments\Paypal\PayPal as cPaypal; //custom Paypal

use PayPal\Rest\ApiContext ;
use PayPal\Auth\OAuthTokenCredential;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use \PayPal\Api\PaymentExecution;



use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;




use v2\Shop\Contracts\OrderInterface;
use Exception, SiteSettings, Config, MIS, Redirect;
/**
 * 
 */
class Subscription  extends cPaypal{

	private $plan ;
	private $paymentDefinition ;
	private $chargeModel ;
	private $merchantPreferences ;


	public function createSubscriptionPlan($plan=null)
	{

		$this->plan = new Plan();

		$this->plan->setName('T-Shirt of the Month Club Plan')
		    ->setDescription('Template creation.')
		    ->setType('fixed');


		    $this->setPaymentDefinition();
		    $this->setChargeModel();
		    $this->setMerchantPreferences();
		    $this->CreateRequest();


		// print_r($this);
	}



	public function setPaymentDefinition($definition = null)
	{
		$this->paymentDefinition = new PaymentDefinition();
		$this->paymentDefinition->setName('Regular Payments')
		    ->setType('REGULAR')
		    ->setFrequency('Month')
		    ->setFrequencyInterval("2")
		    ->setCycles("12")
		    ->setAmount(new Currency(array('value' => 100, 'currency' => parent::$currency)));
	}


	public function setChargeModel($charge_model = null)
	{

		$this->chargeModel = new ChargeModel();
		$this->chargeModel->setType('SHIPPING')
		    ->setAmount(new Currency(array('value' => 10, 'currency' => 'USD')));

		$this->paymentDefinition->setChargeModels(array($this->chargeModel));

	}



	public function setMerchantPreferences($perferences=null)
	{

		$this->merchantPreferences = new MerchantPreferences();
		$baseUrl = Config::domain();

		$this->merchantPreferences->setReturnUrl("$baseUrl/ExecuteAgreement.php?success=true")
		    ->setCancelUrl("$baseUrl/ExecuteAgreement.php?success=false")
		    ->setAutoBillAmount("yes")
		    ->setInitialFailAmountAction("CONTINUE")
		    ->setMaxFailAttempts("0")
		    ->setSetupFee(new Currency(array('value' => 1, 'currency' => 'USD')));

		    $this->plan->setPaymentDefinitions(array($this->paymentDefinition));
		    $this->plan->setMerchantPreferences($this->merchantPreferences);

		    $this->request = clone $this->plan;
	}



	public function CreateRequest()
	{
		try {

		    $this->output = $this->plan->create($this->apiContext);



		} catch (PayPal\Exception\PayPalConnectionException $ex) {
			// print_r("Created Plan", "Plan", null, $this->request, $ex);
			print_r($this->request);
			print_r($ex->getMessage());
			exit(1);
		}


		// print_r("Created Plan", "Plan", $this->output->getId(), $this->request, $this->output);
		// print_r($this->output->getId());
		// print_r($this->request);
		print_r($this->output);
		return $this->output;
	}
}
