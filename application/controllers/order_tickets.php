<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Order_tickets extends CI_Controller {
	public function index()
	{
		// Index is not used at this moment
	}
	// _remap is the redirect function that handles data en decides which view to show
	public function _remap($method, $params){ // Parameter [0] will be the metalink
		// If the user cancels his order
		if($method == 'cancel'){
			$this->buyer_orders->cancelOrder();
		}
		// If ticketdata is posted
		if(isset($_POST['ticketdata']) && isset($_POST['orderid'])){
			$this->buyer_tickets->saveDataPerTicket();
		}
		if(isset($_POST['user']['preferences']) && $this->user->isLoggedIn() == true){
			$this->user->saveSettings();
		}
		if(isset($_POST['tickets'])){
			if(isset($_POST['cancel-ensurance'])){
				$this->session->set_userdata(array('ensurance' => ($_POST['cancel-ensurance'] == 'yes' ? '1' : '0' )));
			}
			$this->session->set_userdata(array('tickets' => $_POST['tickets']));
			$this->session->set_userdata(array('step_one_completed' => true));
		}
		/************************************************************
				Load variable that are being used by all views   		
		************************************************************/
		$data['logged_in'] = ($this->user->isLoggedIn() == true ? true : false);
		
		$data['base'] = $this->config->item('base_url');
		$data['meta'] = $params[0];
		$data['event'] = $this->buyer_events->load_event($params[0]);
		$data['fb_login_url'] = $this->facebook_controller->getLoginUrl();
		$data['scripts'] = $this->load->view('ticketbox/tickets_scripts', $data, true);
		/****************************************************************
			  If user is logged in, set reserved tickets and orderdata
		*****************************************************************/

		if($this->user->isLoggedIn() === true && $this->session->userdata('tickets')){
			$this->buyer_tickets->reserveTickets($params[0]);
		}
		/**
		 * Set orderdata when step two is completed and session doesnt have orderdata yet
		 */
		if($this->user->isLoggedIn() === true && $this->session->userdata('step_one_completed') !== false && $this->session->userdata('step_two_completed') === false && $this->session->userdata('order_id') === false){
			$order_id = $this->buyer_orders->getOrderID();
			$data['order_id'] = $order_id;
		}
		
		/*********************************************************************************
				First of we check if a certain step has been chosen by Ajax already	   		
		*********************************************************************************/
		if($method == 'forth_step'){

		}
		elseif($method == 'third_step'){
			if($this->user->isLoggedIn() === false){
				$this->login_screen($data, $params);
			}
			else{
				$this->third_step($data, $params[0], '');
			}
		}
		elseif($method == 'second_step'){ // If tickets are selected earlier then call 'second_step' with 'new_screen' as param, to show its not an ajax request.
			if($this->user->isLoggedIn() === false){
				$this->login_screen($data, $params, '');
			}
			else{
				$this->second_step($data, $params,'');
			}
		}
		/***************************************************************************************************************
				Then we check if session or database storage has information for us to decide which step we are on   
		***************************************************************************************************************/
		elseif($this->session->userdata('step_one_completed') !== false && $this->session->userdata('step_two_completed') !== false){
			if($this->user->isLoggedIn() === false){
				$this->login_screen($data, $params, 'new_screen');
			}
			else{
				$this->third_step($data, $params[0], 'new_screen');
			}
		}
		/************************************
				   		Step 2
		************************************/
		elseif($this->session->userdata('step_one_completed') !== false){ // If tickets are selected earlier then call 'second_step' with 'new_screen' as param, to show its not an ajax request.
			($this->user->isLoggedIn() === false ? $this->login_screen($data, $params, 'new_screen') : $this->second_step($data, $params[0], 'new_screen'));
		}
		/**********************************************
			If all else fails, show the first step
		**********************************************/
		else{ // If first step needs to be initialized, call 'first_step'
			$this->first_step($data, $params[0], (isset($method) && $method == 'cancel' ? 'no' : 'new_screen')); 
		}
	}
	public function first_step($data, $meta, $new_screen='new_screen'){ 
		$data['step'] = 1;
		if($new_screen == 'new_screen'){
			$this->load->view('ticketbox/header', $data);
			$data['ticketbox'] = $this->load->view('ticketbox/tickets_first_step', $data, true);
			$this->load->view('ticketbox/tickets_box_wrapper', $data);
			$this->load->view('ticketbox/footer', $data);
		}
		else{
			$this->load->view('ticketbox/tickets_first_step', $data);
		}
	}
	/************************************
		Second step in the order process // Additional information is given here
	************************************/	
	public function second_step($data, $meta, $screen=''){
		$data['step'] = 2;
		$data['tickets'] = $this->buyer_tickets->getTicketInformation($this->session->userdata('order_id'));
		$data['order_id'] = $this->session->userdata('order_id');
		$data['user'] = $this->user->getUser();
		if($screen == 'new_screen'){
			$this->load->view('ticketbox/header', $data);
			$data['ticketbox'] = $this->load->view('ticketbox/tickets_second_step', $data, true);
			$this->load->view('ticketbox/tickets_box_wrapper', $data);
			$this->load->view('ticketbox/footer', $data);
		}
		else{
			$this->load->view('ticketbox/tickets_second_step', $data);
		}
	}
	/****************************************************************************	
		Third step in the order process // Additional information is given here
	****************************************************************************/
	public function third_step($data, $params, $screen=''){
		$data['step'] = 3;
		$order_id = $this->session->userdata('order_id');
		$data['order_id'] = $order_id;
		$data['order'] = $this->buyer_orders->getOrderById($order_id);

		/******************************************************
			Assign administration fee(both max and shared)
		******************************************************/
		$data['administration_fee'] = $this->config->item('administration_fee');
		$data['administration_fee_after_shared'] = $this->config->item('administration_fee_after_shared');
		/************************************
			Get Facebook share options
		************************************/
		$data['facebook_metalink'] = htmlspecialchars("http%3A%2F%2Ftibbaa.com/dev/event/".$params);
		$data['facebook_text'] = htmlspecialchars("I'm going to this event!");
		/*****************************************	
			Get reserved tickets from database
		*****************************************/
		$data['tickets'] = $this->buyer_tickets->getTicketsByOrderID($order_id);
		if(!isset($data['tickets'])){
			$this->buyer_orders->clearSessionData();
			$this->first_step($data, $params[0], '');
			exit();
		}
		$total = 0;

		/************************************
					Calculate total
		************************************/
		$this->load->model('payment_model');
		$totals = $this->payment_model->getTotalPrice($data);
		$data['ensurance'] = $totals['ensurance'];
		$data['paymentform'] = $this->payment_model->getPaymentformData(array( 'total' => $totals['total'], 'merchantReference' => $order_id, 'paymentAmount' => $totals['total'] ), $data);
		$data['transactionfee'] = ($totals['transactionfee']/100);
		if($screen == 'new_screen'){
			$this->load->view('ticketbox/header', $data);
			$data['ticketbox'] = $this->load->view('ticketbox/tickets_third_step', $data, true);
			$this->load->view('ticketbox/tickets_box_wrapper', $data);
			$this->load->view('ticketbox/footer', $data);
		}
		else{
			$this->load->view('ticketbox/tickets_third_step', $data);
		}
	}
	public function login_screen($data, $meta, $new_screen=''){ // When the user isnt logged in at a certain screen
		$data['step'] = 2;
		if($new_screen == 'new_screen'){
			$this->load->view('ticketbox/header', $data);
			$this->load->view('ticketbox/tickets_second_step_login', $data);
			//$this->load->view('ticketbox/tickets_box_wrapper', $data);
			$this->load->view('ticketbox/footer', $data);
		}
		else{
			$this->load->view('ticketbox/tickets_second_step_login', $data);
		}
	}
}