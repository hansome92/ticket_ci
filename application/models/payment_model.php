<?php 
class Payment_model extends CI_Model
{
	/**
	 *	Object properties
	 */
	private $wizard;
	private $database;
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->database = $this->db->conn_id;
		$this->hmacKey = "ENZoqhfl";
	}
	public function getTotalPrice($data=null){
		$total = 0;
		$totalEnsurance = 0;
		$adminFee = 0;
		$transactionFee = 60;
		/*
			First get total 
		 */
		foreach ($data['tickets'] as $key => $value) {
			if(!is_numeric( $value['preferences']['tickets-ppt']['Value']) ){
				$value['preferences']['tickets-ppt']['Value'] = str_replace(',', '.', $value['preferences']['tickets-ppt']['Value']);
			}
			$total += ($value['preferences']['tickets-ppt']['Value'] * $value['Quantity'] * 100);
			if(isset($value['buyerpreferences'][1]['Value']) && $value['buyerpreferences'][1]['Value'] == 1){
				$totalEnsurance += (($value['preferences']['tickets-ppt']['Value'] * $value['Quantity']) * 10); 
			}
			/*
				Fix the administration fee price
			 */
			if(isset($data['order']['preferences']['shared_on_facebook']) && $data['order']['preferences']['shared_on_facebook']['Value'] == '1'){
				//echo (str_replace('.', '', $value['preferences']['fb-shared-ticketfee']['Value'])/100) * $value['Quantity'];
				
				$adminFee += ((str_replace('.', '', $value['preferences']['fb-shared-ticketfee']['Value'])/100) * 1 * $value['Quantity']);
			}
			else{
				$adminFee += ((str_replace('.', '', $value['preferences']['fb-unshared-ticketfee']['Value'])/100) * 1 * $value['Quantity']);
			}
		}
		// Add ensurance to data
		$data['ensurance'] = $totalEnsurance;
		/*
			Add the ensurance total to general total
		 */
		$total += $totalEnsurance;
		$total += $adminFee*100;
		$total += $transactionFee;
		return array('total' => $total, 'ensurance' => $totalEnsurance/100, 'adminfee' => $adminFee, 'transactionfee' => $transactionFee);
	}

	
	public function getPaymentformData($params=null, $result=null){
		/*$result['merchantReference'] = $params['merchantReference'];*/
		$result['paymentAmount'] = $params['paymentAmount'];	
		/*$result['currencyCode'] = "EUR";
		$result['shipBeforeDate'] = date("Y-m-d",strtotime("+3 days")); 
		$result['skinCode'] = "ENZoqhfl";
		$result['merchantAccount'] = "BRPRHoldingNL";
		$result['sessionValidity'] = date("c",strtotime("+1 days"));
		$result['shopperLocale'] = "nl_NL";
		$result['orderData'] = base64_encode(gzencode("Orderdata to display on the HPP can be put here"));
		$result['countryCode'] = "NL"; 
		$result['shopperEmail'] = $this->user->getEmail();
		$result['shopperReference'] = $this->session->userdata('user_id'); 
		$result['allowedMethods'] = "";
		$result['blockedMethods'] = "";
		$result['offset'] = ""; 

		

		$result['merchantSig'] = base64_encode(pack("H*",hash_hmac(
			'sha1',
			$result['paymentAmount'] . $result['currencyCode'] . $result['shipBeforeDate'] . $result['merchantReference'] . $result['skinCode'] . $result['merchantAccount'] . 
			$result['sessionValidity'] . $result['shopperEmail'] . $result['shopperReference'] . $result['allowedMethods'] . $result['blockedMethods'] . $result['offset'],
			$this->hmacKey
		)));*/

		define('MERCHANTID', 22782);//<--- Change this into your own merchant ID
		define('SECRETCODE', "b7YEr8f4P6Hxj9G5AzTn33RpFs45Lgu9C7Scy8UJ");//<--- Change this into your own merchant ID 

		// Include the API
		require_once './icepay/icepay_api_basic.php';

		/* Apply logging rules */
		$logger = Icepay_Api_Logger::getInstance();
		$logger->enableLogging()
		        ->setLoggingLevel(Icepay_Api_Logger::LEVEL_ALL)
		        ->logToFile()
		        ->setLoggingDirectory(realpath("./logs"))
		        ->setLoggingFile("icepay_logs.txt")
		        ->logToScreen();


		/* Set the paymentObject */
		$paymentObj = new Icepay_PaymentObject();
		$paymentObj->setAmount($params['paymentAmount'])
		            ->setCountry("NL")
		            ->setLanguage("NL")
		            ->setReference("Tibbaa")
		            ->setDescription("Payment Order: ".$params['merchantReference'])
		            ->setCurrency("EUR")
		            ->setOrderID($params['merchantReference']);

		try {
		    // Merchant Settings
		    $basicmode = Icepay_Basicmode::getInstance();
		    $basicmode->setMerchantID(MERCHANTID)
		            ->setSecretCode(SECRETCODE)
		            ->validatePayment($paymentObj);
		}catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}


		$result['payment_url'] = $basicmode->getURL();

		return $result;
	}
}
?> 