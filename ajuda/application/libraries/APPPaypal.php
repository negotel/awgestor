<?php
/**
 * Create Date: Nov 10, 2016 5:33:23 PM
 */
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Sale;
use PayPal\Api\Refund;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\Order;
class APPPaypal{
 	private $merchant_id;
 	public $isTestMode;
 	private $clientID;
 	private $clientSecret;
 	public $isPaypalEnabled; 	
 	function __construct()
 	{ 		
 		$this->merchant_id=""; 		
 		$userdata = GetUserData();
 		$this->clientID=Mapp_setting_api::GetSettingsValue("paypal", "client_id");
 		$this->clientSecret=Mapp_setting_api::GetSettingsValue("paypal", "secret");
 		$this->isPaypalEnabled=Mapp_setting_api::GetSettingsValue("paypal", "is_enable_paypal","N")=="Y";
 		$this->isTestMode=Mapp_setting_api::GetSettingsValue("paypal", "is_test_mode","N")=="Y";
 		//$this->customer_id = $userdata->customer_id;
 	}
 	/**
 	 * @return \PayPal\Rest\ApiContext
 	 */
 	public function getApiContext(){
 		$apiContext = new ApiContext(
 				new OAuthTokenCredential(
 						$this->clientID,
 						$this->clientSecret
 				)
 		);
 	
 		// Comment this line out and uncomment the PP_CONFIG_PATH
 		// 'define' block if you want to use static file
 		// based configuration
 	
 	
 		$apiContext->setConfig(
 				array(
 						'mode' => $this->isTestMode?'sandbox':'live',
 						'log.LogEnabled' => $this->isTestMode,
 						'log.FileName' => APPPATH.'logs/PayPal.log',
 						'log.LogLevel' => $this->isTestMode?'DEBUG':'INFO', // PLEASE USE `INFO` LEVEL FOR LOGGING IN LIVE ENVIRONMENTS
 						'cache.enabled' => false,
 						// 'http.CURLOPT_CONNECTTIMEOUT' => 30
 						// 'http.headers.PayPal-Partner-Attribution-Id' => '123123123'
 						//'log.AdapterFactory' => '\PayPal\Log\DefaultLogFactory' // Factory class implementing \PayPal\Log\PayPalLogFactory
 				)
 		);
 		return $apiContext;
 	}
 	
 	public function process_single_payment($payment_id,$des,$amount,$success_url,$cancel_url,$shipping=0.0,$currency="USD"){
 	    $apiContext=$this->getApiContext();
 	    $currency=strtoupper($currency);
 	   
 	    //payer
 	    $payer = new Payer();
 	    $payer->setPaymentMethod("paypal");
 	    $itemList = new ItemList();
 	    if(strlen($des)>127){
 	        $item_name=substr($des, 0,127);
 	    }else{
 	        $item_name=$des;
 	    }
 	    $item = new Item();
 	    $item->setName($item_name)
 	    ->setCurrency($currency)
 	    ->setQuantity(1)
 	    ->setSku("payment") // Similar to `item_number` in Classic API
 	    ->setPrice($amount);
 	    $itemList->addItem($item);
 	     
 	    // ### Additional payment details
 	    // Use this optional field to set additional
 	    // payment information such as tax, shipping
 	    // charges etc.
 	    $amount=$amount+$shipping;
 	    $details = new Details();
 	    $details->setShipping($shipping)
 	    ->setTax(0)
 	    ->setSubtotal($amount);
 	    
 	    // ### Amount
 	    // Lets you specify a payment amount.
 	    // You can also specify additional details
 	    // such as shipping, tax.
 	    $amount_obj = new Amount();
 	    $amount_obj->setCurrency($currency)
 	    ->setTotal( $amount)
 	    ->setDetails($details);
 	    
 	    // ### Transaction
 	    // A transaction defines the contract of a
 	    // payment - what is the payment for and who
 	    // is fulfilling it.
 	    $transaction = new Transaction();
 	    $transaction->setAmount($amount_obj)
 	    ->setItemList($itemList)
 	    ->setDescription($des)
 	    ->setInvoiceNumber($payment_id);
 	    
 	    // ### Redirect urls
 	    // Set the urls that the buyer must be redirected to after
 	    // payment approval/ cancellation.
 	    $baseUrl = base_url();
 	    //$success_url=user_url("gtalk-payment/paypal-process/Y/$order_id");
 	    //$cancel_url=user_url("gtalk-payment/paypal-process/C/$order_id");
 	    $redirectUrls = new RedirectUrls();
 	    $redirectUrls->setReturnUrl($success_url)
 	    ->setCancelUrl($cancel_url);
 	    
 	    // ### Payment
 	    // A Payment Resource; create one using
 	    // the above types and intent set to 'sale'
 	    $payment = new Payment();
 	    $payment->setIntent("sale")
 	    ->setPayer($payer)
 	    ->setRedirectUrls($redirectUrls)
 	    ->setTransactions(array($transaction));
 	    
 	    
 	    // For Sample Purposes Only.
 	    $request = clone $payment; 	 
 	    // ### Create Payment
 	    // Create a payment by calling the 'create' method
 	    // passing it a valid apiContext.
 	    // (See bootstrap.php for more on `ApiContext`)
 	    // The return object contains the state and the
 	    // url to which the buyer must be redirected to
 	    // for payment approval
 	    try {
 	        $payment->create($apiContext);
 	    }catch (PayPal\Exception\PayPalConnectionException $ex) {
 	        Mdebug_log::AddPaypalLog("Paypal Payment Error for id({$payment_id})", Mdebug_log::STATUS_FAILED, Mdebug_log::ENTRY_TYPE_ERROR,$ex->getData()); 	        
 	       return false; 	       
 	    
 	    } catch (Exception $ex) {
 	        Mdebug_log::AddPaypalLog("Paypal Payment Error for id({$payment_id})".$this->subject_str, Mdebug_log::STATUS_FAILED, Mdebug_log::ENTRY_TYPE_ERROR,$ex->getData());
 	        return false;
 	        	
 	    }
 	    	
 	    // ### Get redirect url
 	    // The API response provides the url that you must redirect
 	    // the buyer to. Retrieve the url from the $payment->getApprovalLink()
 	    // method
 	    $approvalUrl = $payment->getApprovalLink();
 	    redirect($approvalUrl);
 	    return true;
 	    
 	}
 	
 	
 	/**
 	 * @param unknown $refundAmount
 	 * @param unknown $saleId
 	 * @param PayPal\Api\Refund $refundedSale
 	 */
 	public function refundBySale($refundAmount,$saleId,&$refundedSale=NULL){
 		$apiContext=$this->getApiContext();
 		try {
 			$amount = new Amount();
 			$amount->setCurrency("USD")
 			->setTotal($refundAmount);
 			
 			
 			// ### Retrieve the sale object
 			// Pass the ID of the sale
 			// transaction from your payment resource.
 			$sale = Sale::get($saleId, $apiContext); 	
 			$state=$sale->getState();
 			if($state!="completed" || $state=="refunded"){
 				return false;
 			}
 			$refund = new Refund();
 			$refund->setAmount($amount); 			
 			$refundedSale = $sale->refund($refund, $apiContext);
 			if($refundedSale->getState()=="completed"){
 					return true;
 			}
 			return false;
 			
 		} catch (PayPal\Exception\PayPalConnectionException $ex) {
 			// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 			AddFileLog("Error on Refund".$ex->getData());
 			
 		}catch (Exception $ex) {
 			// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
 			AddFileLog("Error on Refund".$ex->getMessage());
 			
 		}
 		return false;
 	}
 }