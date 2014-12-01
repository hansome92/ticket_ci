<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example_Order {
    protected $status = "OPEN";
    public function loadByOrderID($id) {}
    public function getStatus() {return $this->status;}
    public function saveStatus($status) {$this->status = $status;}
    public function updateStatusHistory($string) {$this->sendMail($string);}
    public function sendMail($string){/*mail(EMAIL, "api test: ".$this->status, $string);*/}
}

class Order_complete extends CI_Controller {
	
	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		
		define('MERCHANTID', 22782);//<--- Change this into your own merchant ID
		define('SECRETCODE', "b7YEr8f4P6Hxj9G5AzTn33RpFs45Lgu9C7Scy8UJ");//<--- Change this into your own merchant ID
		define('EMAIL',"mike@redmelon.nl");//<--- Change this into your own e-mail address
		require_once './icepay/icepay_api_basic.php';
		$this->database = $this->db->conn_id;
	}
	public function _remap($method, $params=NULL){
		$this->$method($params);
	}
	public function failed($params){
		$data['step'] = 'complete';
		$order_id = $_GET['OrderID'];
		$data['order'] = $this->buyer_orders->getOrderById($order_id);
		
		$data['event'] = $this->buyer_events->getEventDataByID($data['order']['eticketbuyer'][0]['EventID']);

		$this->buyer_orders->clearSessionData();

		$data['base'] = $this->config->item('base_url');
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['fb_login_url'] = $this->facebook_controller->getLoginUrl();
		$data['scripts'] = $this->load->view('ticketbox/tickets_scripts', $data, true);
		$this->load->view('ticketbox/header', $data);
		$this->load->view('ticketbox/failed', $data);
	}
	public function postback($params){

		/* Apply logging rules */
		$logger = Icepay_Api_Logger::getInstance();
		$logger->enableLogging()
		        ->setLoggingLevel(Icepay_Api_Logger::LEVEL_ALL)
		        ->logToFile()
		        ->setLoggingDirectory(realpath("../logs"))
		        ->setLoggingFile("postback.txt")
		        ->logToScreen();

		/* Start the postback class */
		$icepay = new Icepay_Postback();
		$icepay->setMerchantID(MERCHANTID)
		        ->setSecretCode(SECRETCODE)
		        ->doIPCheck(); // We encourage to enable ip checking for your own security

		$order  = new Example_Order(); // This is a dummy class to depict a sample usage.

		try {
		    if($icepay->validate()){
		        // In this example the ICEPAY OrderID is identical to the Order ID used in our project
		        $order->loadByOrderID($icepay->getOrderID());

		        /* Only update the status if it's a new order (NEW)
		         * or update the status if the statuscode allowes it.
		         * In this example the project order status is an ICEPAY statuscode.
		         */
		        if ($order->getStatus() == "NEW" || $icepay->canUpdateStatus($order->getStatus())){
		            
		            $order->saveStatus($icepay->getStatus()); //Update the status of your order
		            $data['order_result'] = $this->buyer_orders->handle_order($icepay->getOrderID(), $order->getStatus());
		            $order->sendMail(sprintf("icepay_status_update_to_%s",$order->getStatus()));
		        }
		        $order->updateStatusHistory($icepay->getTransactionString());
		    } else die ("Unable to validate postback data");

		} catch (Exception $e){
		    echo($e->getMessage());
		}
	}
	public function success(){
		$data['step'] = 'complete';
		$order_id = $_GET['OrderID'];
	
		$data['order'] = $this->buyer_orders->getOrderById($order_id);
		
		$data['event'] = $this->buyer_events->getEventDataByID($data['order']['eticketbuyer'][0]['EventID']);

		$this->buyer_orders->clearSessionData();

		$data['base'] = $this->config->item('base_url');
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['fb_login_url'] = $this->facebook_controller->getLoginUrl();
		$data['scripts'] = $this->load->view('ticketbox/tickets_scripts', $data, true);
		$this->load->view('ticketbox/header', $data);
		$this->load->view('ticketbox/confirmation', $data);
		$this->load->view('ticketbox/footer', $data);
	}
	public function index()
	{
		$data['step'] = 'complete';

		$data['order_result'] = $this->buyer_orders->handle_order();
		$data['order'] = $this->buyer_orders->getOrderById($_GET['merchantReference']);
		
		$data['event'] = $this->buyer_events->getEventDataByID($data['order']['eticketbuyer'][0]['EventID']);

		$this->buyer_orders->clearSessionData();

		$data['base'] = $this->config->item('base_url');
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		$data['fb_login_url'] = $this->facebook_controller->getLoginUrl();
		$data['scripts'] = $this->load->view('ticketbox/tickets_scripts', $data, true);
		$this->load->view('ticketbox/header', $data);
		$this->load->view('ticketbox/confirmation', $data);
	}
	public function newtickets($event_id){
		if(isset($_POST['preferences'])){
			// Make the new ticket, $result contains the ID the system generates so we can direct the user to the proper eventpage
			$result = $this->events->registerNewTickettype($event_id);
			if($result !== false){
				// Returns json code so the script 
				echo json_encode(array('redirect', $this->config->item('base_url')."promoter/event/".$result));
			}
		}
		else{
			// Standard variables for header
			$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
			$data['base'] = $this->config->item('base_url');
			$this->load->model('Wizard');
			$data['cur_wizard'] = $this->Wizard->set_current_wizard(5);
			$data['wizard'] = $this->Wizard->load_fields();
			$data['wizard_url'] = 'promoter/event/'.$event_id.'/newtickets';
			$this->load->view('header', $data);
			if ($this->user->isLoggedIn()) {
				$this->load->view('wizard', $data);
			}
		}
	}
}
